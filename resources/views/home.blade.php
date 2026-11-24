@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-3xl py-16 text-center sm:py-24">
        <p class="text-xs font-semibold uppercase tracking-wider text-orange-600">Community parts guide · starting with Quatt</p>
        <h1 class="mt-4 text-4xl font-bold tracking-tight sm:text-6xl">
            Know what's inside your heat pump.
            <span class="bg-gradient-to-r from-orange-600 to-amber-500 bg-clip-text text-transparent">And where to get the part.</span>
        </h1>
        <p class="mx-auto mt-6 max-w-xl text-lg text-stone-600">
            Pick your model, see a diagram of its main parts and find shops that sell them, suggested and checked by other owners.
        </p>
    </section>

    @foreach ($brands as $brand)
        <section class="mb-12">
            <h2 class="text-xl font-semibold">{{ $brand->name }}</h2>
            <p class="mt-1 text-sm text-stone-500">Pick the hardware version printed on the label.</p>

            <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($brand->units as $unit)
                    <a href="{{ route('units.show', [$brand, $unit]) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg">
                        <div class="relative grid h-32 place-items-center border-b border-stone-200 bg-gradient-to-br from-orange-50 to-orange-100/60">
                            <span class="absolute left-3 top-3 rounded-full bg-stone-900 px-2.5 py-1 text-xs font-bold text-white">{{ $unit->name }}</span>
                            <svg viewBox="0 0 120 100" class="h-20">
                                <rect x="8" y="22" width="104" height="66" rx="10" fill="#fff" stroke="#1c1917" stroke-width="2.5"/>
                                <circle cx="44" cy="55" r="24" fill="#f5f5f4" stroke="#1c1917" stroke-width="2"/>
                                <circle cx="44" cy="55" r="6" fill="#ea580c"/>
                                <rect x="78" y="34" width="24" height="10" rx="3" fill="#ea580c"/>
                                <rect x="78" y="50" width="24" height="26" rx="6" fill="#e7e5e4"/>
                            </svg>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <p class="text-xs font-medium text-stone-500">{{ ucfirst($unit->type->value) }} unit</p>
                            <h3 class="mt-1 text-lg font-semibold">{{ $unit->full_name }}</h3>
                            <p class="mt-auto pt-4 text-sm font-semibold text-orange-600">
                                {{ $unit->unit_parts_count }} parts mapped <span class="inline-block transition group-hover:translate-x-1">&rarr;</span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach

    <section class="grid gap-5 md:grid-cols-2">
        <div class="flex gap-4 rounded-2xl border border-stone-200 bg-white/70 p-5 text-sm text-stone-600">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-orange-50 text-orange-600">&#8644;</span>
            <div>
                <h3 class="font-semibold text-stone-900">Hybrid, Duo or All-Electric?</h3>
                <p class="mt-1">The outdoor unit is the same in every setup. A Duo just has two of them, and All-Electric adds indoor units.</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-stone-200 bg-white/70 p-5 text-sm text-stone-600">
            <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-orange-50 text-orange-600">?</span>
            <div>
                <h3 class="font-semibold text-stone-900">Not sure which version you have?</h3>
                <ul class="mt-1 space-y-1">
                    <li><strong class="text-stone-900">V1</strong>: label says <code class="rounded bg-stone-100 px-1.5 font-mono text-xs">AMM4</code>, with a flow meter near the CV boiler</li>
                    <li><strong class="text-stone-900">V1.5</strong>: label says <code class="rounded bg-stone-100 px-1.5 font-mono text-xs">AMM4-V1.5</code>, R32, smaller unit with the flow meter built in</li>
                    <li><strong class="text-stone-900">V2</strong>: label says <code class="rounded bg-stone-100 px-1.5 font-mono text-xs">AMH6</code> or <code class="rounded bg-stone-100 px-1.5 font-mono text-xs">AMH6-2</code>, R290, bigger with a plastic front</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="mt-16 grid gap-5 md:grid-cols-3">
        @foreach ([
            ['Pick your model', 'Choose your unit. Check the label if you\'re unsure which version you have.'],
            ['Find the part', 'Tap a number in the diagram to see what the part does and what\'s known about it.'],
            ['Share a shop', 'Found a part somewhere? Suggest the link. After review it shows up for everyone.'],
        ] as [$heading, $text])
            <div class="rounded-2xl border border-stone-200 bg-white/70 p-5">
                <span class="grid size-7 place-items-center rounded-lg bg-stone-900 text-sm font-bold text-white">{{ $loop->iteration }}</span>
                <h3 class="mt-4 font-semibold">{{ $heading }}</h3>
                <p class="mt-1 text-sm text-stone-600">{{ $text }}</p>
            </div>
        @endforeach
    </section>
@endsection
