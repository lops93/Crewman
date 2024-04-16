<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
    ];

    protected $appends = ['employment_status'];

    protected $dates = ['deleted_at'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function getEmploymentStatusAttribute(): string
    {
        $currentDate = Carbon::now();
        $startDate = Carbon::parse($this->start_date);
        $endDate = $this->end_date ? Carbon::parse($this->end_date) : null;

        switch (true) {
            case ($endDate && $endDate->isPast()):
                return 'Past Employment';
            case ($startDate->isSameDay($currentDate) and $startDate->isPast()):
                return 'Current Employment';
            case ($startDate->isFuture()):
                return 'Future Employment';
            default:
                return 'Unknown';
        }
        
    }
}
