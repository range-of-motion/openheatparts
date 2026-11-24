<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $brands = Brand::query()
            ->with(['units' => fn ($query) => $query->withCount('unitParts')])
            ->orderBy('name')
            ->get();

        return view('home', ['brands' => $brands]);
    }
}
