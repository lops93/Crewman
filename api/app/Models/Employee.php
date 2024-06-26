<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'identification_number',
    ];

    protected $appends = ['is_active'];
    
    protected $dates = ['deleted_at'];

    public function employments(): HasMany
    {
        return $this->hasMany(Employment::class);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->employments()->exists();
    }
}
