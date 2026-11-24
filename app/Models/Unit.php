<?php

namespace App\Models;

use App\Enums\UnitType;
use Database\Factories\UnitFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['brand_id', 'name', 'slug', 'type', 'diagram_path'])]
class Unit extends Model
{
    /** @use HasFactory<UnitFactory> */
    use HasFactory;

    protected function fullName(): Attribute
    {
        return Attribute::get(fn () => trim($this->brand->name.' '.$this->name));
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return HasMany<UnitPart, $this>
     */
    public function unitParts(): HasMany
    {
        return $this->hasMany(UnitPart::class)->orderBy('diagram_number');
    }

    /**
     * @return BelongsToMany<Part, $this>
     */
    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class, 'unit_parts')
            ->withPivot([
                'diagram_number',
                'part_number',
                'position_x',
                'position_y',
                'specs',
                'confidence',
            ])
            ->withTimestamps()
            ->orderByPivot('diagram_number');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => UnitType::class,
        ];
    }
}
