<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Part;
use App\Models\Unit;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function show(Brand $brand, Unit $unit, ?Part $part = null): View
    {
        $unit->load(['brand', 'unitParts.part', 'unitParts.partLinks']);

        $diagramPath = $unit->diagram_path ? public_path($unit->diagram_path) : null;

        return view('units.show', [
            'brand' => $brand,
            'unit' => $unit,
            'versions' => $brand->units,
            'selected' => $part ? $unit->unitParts->firstWhere('part_id', $part->id) : null,
            'diagram' => $diagramPath && is_file($diagramPath) ? file_get_contents($diagramPath) : null,
        ]);
    }
}
