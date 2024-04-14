<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
    ];

    protected $dates = ['deleted_at'];

    public function employment(): BelongsTo
    {
        return $this->belongsTo(Employment::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'assignment_location', 'assignment_id', 'location_id');
    }

    public function assignmentRoles(): HasMany
    {
        return $this->hasMany(AssignmentRole::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }
}
