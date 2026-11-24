@extends('layouts.app')

@section('title', $unit->full_name)

@section('content')
    @php
        $badges = [
            'documented' => ['Documented', 'bg-green-50 text-green-700'],
            'community' => ['Community', 'bg-blue-50 text-blue-700'],
            'unverified' => ['Unverified', 'bg-amber-50 text-amber-700'],
        ];
    @endphp

    @if ($selected)
        <style>
            .diagram .part { opacity: .32 }
            .diagram [data-part="{{ $selected->part->slug }}"] { opacity: 1; filter: drop-shadow(0 0 10px rgba(232, 89, 12, .55)) }
        </style>
    @endif

    <nav class="pt-8 text-xs text-stone-500">
        <a href="{{ route('home') }}" class="font-medium text-stone-700 hover:text-orange-600">&larr; All models</a>
        <span class="mx-1">/</span> {{ $brand->name }}
        <span class="mx-1">/</span> {{ ucfirst($unit->type->value) }} unit
        <span class="mx-1">/</span> {{ $unit->full_name }}
    </nav>

    <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-orange-600">{{ $unit->type->value }} unit</p>
    <h1 class="mt-2 text-4xl font-bold tracking-tight">{{ $unit->full_name }}</h1>
    <p class="mt-2 text-stone-600">{{ $unit->unitParts->count() }} parts mapped. Pick a number in the diagram to see the part.</p>

    @if ($versions->count() > 1)
        <div class="mt-6 inline-flex rounded-xl border border-stone-200 bg-stone-100 p-1">
            @foreach ($versions as $version)
                <a href="{{ route('units.show', [$brand, $version]) }}" @class([
                    'rounded-lg px-4 py-1.5 text-sm font-semibold',
                    'bg-white text-stone-900 shadow-sm' => $version->is($unit),
                    'text-stone-600 hover:text-stone-900' => ! $version->is($unit),
                ])>{{ $version->full_name }}</a>
            @endforeach
        </div>
    @endif

    <div class="mt-6 grid items-start gap-6 lg:grid-cols-[1fr_380px]">
        <div class="rounded-2xl border border-stone-200 bg-white p-4 shadow-sm">
            @if ($diagram)
                <div class="diagram relative rounded-xl border border-stone-100 bg-[#FCFAF7]">
                    {!! $diagram !!}
                    @foreach ($unit->unitParts as $unitPart)
                        @if ($unitPart->position_x !== null)
                            <a href="{{ route('units.show', [$brand, $unit, $unitPart->part]) }}"
                               title="{{ $unitPart->part->name }}"
                               style="left: {{ $unitPart->position_x }}%; top: {{ $unitPart->position_y }}%"
                               @class([
                                   'absolute grid size-6 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full text-[11px] font-bold text-white ring-2 ring-white transition hover:scale-110',
                                   'bg-orange-600 scale-125' => $selected?->is($unitPart),
                                   'bg-stone-900' => ! $selected?->is($unitPart),
                               ])>{{ $unitPart->diagram_number }}</a>
                        @endif
                    @endforeach
                </div>
            @endif

            <ol class="mt-4 grid gap-1 sm:grid-cols-2">
                @foreach ($unit->unitParts as $unitPart)
                    <li>
                        <a href="{{ route('units.show', [$brand, $unit, $unitPart->part]) }}" @class([
                            'flex items-center gap-3 rounded-lg px-3 py-2 text-sm',
                            'bg-orange-50 font-medium text-orange-700' => $selected?->is($unitPart),
                            'text-stone-700 hover:bg-stone-50' => ! $selected?->is($unitPart),
                        ])>
                            <span class="grid size-6 shrink-0 place-items-center rounded-full bg-stone-100 text-xs font-bold text-stone-700">{{ $unitPart->diagram_number }}</span>
                            {{ $unitPart->part->name }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>

        <aside class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm lg:sticky lg:top-24">
            @if ($selected)
                <div class="flex items-center gap-2">
                    <span class="grid size-7 place-items-center rounded-lg bg-orange-600 text-sm font-bold text-white">{{ $selected->diagram_number }}</span>
                    <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $badges[$selected->confidence->value][1] }}">{{ $badges[$selected->confidence->value][0] }}</span>
                    <a href="{{ route('units.show', [$brand, $unit]) }}" class="ml-auto grid size-8 place-items-center rounded-full bg-stone-100 text-stone-500 hover:text-stone-900" aria-label="Close">&times;</a>
                </div>

                <h2 class="mt-3 text-xl font-semibold">{{ $selected->part->name }}</h2>

                @if ($selected->specs)
                    <dl class="mt-4 divide-y divide-stone-100 rounded-xl border border-stone-200 text-sm">
                        @foreach ($selected->specs as $label => $value)
                            <div class="grid grid-cols-[2fr_3fr] gap-3 px-3 py-2.5">
                                <dt class="text-stone-500">{{ $label }}</dt>
                                <dd class="font-medium">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                <div class="mt-4 rounded-xl border border-dashed border-amber-300 bg-amber-50 px-3 py-2.5 text-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Part number</p>
                    <p class="font-semibold">{{ $selected->part_number ?? 'Unknown, help us find it' }}</p>
                </div>

                <h3 class="mt-6 text-xs font-semibold uppercase tracking-wider text-stone-500">Where to buy</h3>
                @forelse ($selected->partLinks as $link)
                    <a href="{{ $link->url }}" target="_blank" rel="noopener nofollow" class="mt-2 flex items-center justify-between rounded-xl border border-stone-200 px-4 py-3 text-sm font-medium hover:border-orange-300">
                        {{ $link->shop_name }} <span aria-hidden="true">&nearr;</span>
                    </a>
                @empty
                    <p class="mt-2 text-sm text-stone-500">No shop links yet.</p>
                @endforelse

                @if (session('status'))
                    <p class="mt-3 rounded-xl bg-green-50 px-3 py-2.5 text-sm text-green-700">{{ session('status') }}</p>
                @endif

                <details class="mt-3 rounded-xl border border-dashed border-stone-300" @if ($errors->any()) open @endif>
                    <summary class="cursor-pointer list-none px-4 py-3 text-center text-sm font-medium text-stone-600 hover:text-stone-900">+ Suggest a link</summary>

                    <form method="POST" action="{{ route('part-links.store', [$brand, $unit, $selected->part]) }}" class="space-y-3 border-t border-dashed border-stone-300 p-4">
                        @csrf

                        <div class="hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div>
                            <label for="url" class="text-xs font-semibold uppercase tracking-wide text-stone-500">Link</label>
                            <input type="url" id="url" name="url" value="{{ old('url') }}" required maxlength="2048" placeholder="https://"
                                   class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500">
                            @error('url')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shop_name" class="text-xs font-semibold uppercase tracking-wide text-stone-500">Shop name</label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}" required maxlength="100"
                                   class="mt-1 w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500">
                            @error('shop_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @error('website')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="w-full rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-700">Submit link</button>
                    </form>
                </details>
                <p class="mt-3 text-xs text-stone-400">Links are reviewed before they're listed.</p>
            @else
                <div class="py-10 text-center">
                    <div class="text-3xl text-orange-500">&#9678;</div>
                    <h2 class="mt-2 font-semibold">Select a part</h2>
                    <p class="mt-1 text-sm text-stone-500">Tap a number in the diagram, or pick one from the list.</p>
                </div>
            @endif
        </aside>
    </div>
@endsection
