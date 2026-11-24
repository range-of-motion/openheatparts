<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartLinkRequest;
use App\Models\Brand;
use App\Models\Part;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;

class PartLinkController extends Controller
{
    public function store(StorePartLinkRequest $request, Brand $brand, Unit $unit, Part $part): RedirectResponse
    {
        $unitPart = $unit->unitParts()->where('part_id', $part->id)->firstOrFail();

        $unitPart->partLinks()->create([
            'user_id' => $request->user()?->id,
            'url' => $request->validated('url'),
            'shop_name' => $request->validated('shop_name'),
        ]);

        return to_route('units.show', [$brand, $unit, $part])
            ->with('status', 'Thanks! Your link will appear once it has been reviewed.');
    }
}
