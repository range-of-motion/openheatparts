<?php

namespace App\Models;

use Database\Factories\PartFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug'])]
class Part extends Model
{
    /** @use HasFactory<PartFactory> */
    use HasFactory;

    /**
     * @return HasMany<UnitPart, $this>
     */
    public function unitParts(): HasMany
    {
        return $this->hasMany(UnitPart::class);
    }

    /**
     * @return BelongsToMany<Unit, $this>
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'unit_parts')
            ->withPivot([
                'diagram_number',
                'part_number',
                'position_x',
                'position_y',
                'specs',
                'confidence',
            ])
            ->withTimestamps()
            ->orderBy('units.name')
            ->orderBy('units.id');
    }
}
