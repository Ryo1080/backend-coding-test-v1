<?php

namespace App\Models\Household;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseholdMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'house_hold_id',
        'first_name',
        'last_name',
        'birthday',
        'relationship',
    ];

    /**
     * @return BelongsTo<Household, HouseholdMember>
     */
    public function houseHold(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }
}
