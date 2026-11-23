<?php

namespace App\Models;

use Database\Factories\PartLinkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['unit_part_id', 'user_id', 'url', 'shop_name'])]
class PartLink extends Model
{
    /** @use HasFactory<PartLinkFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<UnitPart, $this>
     */
    public function unitPart(): BelongsTo
    {
        return $this->belongsTo(UnitPart::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
