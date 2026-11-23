<?php

namespace App\Models;

use App\Enums\Confidence;
use Database\Factories\UnitPartFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'unit_id',
    'part_id',
    'diagram_number',
    'part_number',
    'position_x',
    'position_y',
    'specs',
    'confidence',
])]
class UnitPart extends Model
{
    /** @use HasFactory<UnitPartFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Unit, $this>
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * @return BelongsTo<Part, $this>
     */
    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    /**
     * @return HasMany<PartLink, $this>
     */
    public function partLinks(): HasMany
    {
        return $this->hasMany(PartLink::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position_x' => 'decimal:2',
            'position_y' => 'decimal:2',
            'specs' => 'array',
            'confidence' => Confidence::class,
        ];
    }
}
