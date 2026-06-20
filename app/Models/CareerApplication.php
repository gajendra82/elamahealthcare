<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplication extends Model
{
    protected $fillable = [
        'career_job_id',
        'name',
        'email',
        'phone',
        'resume_path',
        'cover_letter',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'career_job_id' => 'integer',
        ];
    }

    public function careerJob(): BelongsTo
    {
        return $this->belongsTo(CareerJob::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->latest();
    }
}
