<?php

namespace App\Models\Household;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'phone_number',
        'email',
        'postal_code',
        'address',
    ];

    /**
     * @return HasMany<HouseholdMember>
     */
    public function householdMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class);
    }
}
