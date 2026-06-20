<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'category',
        'product_name',
        'composition',
        'dosage',
        'packaging',
        'description',
        'image',
        'slug',
        'status',
        'format',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
        ];
    }

    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeAlphabetical(Builder $query): Builder
    {
        return $query->orderBy('product_name');
    }

    public function scopeInCategory(Builder $query, int|string $category): Builder
    {
        if (is_numeric($category)) {
            return $query->where('category_id', $category);
        }

        return $query->whereHas('categoryRelation', fn (Builder $q) => $q->where('slug', $category));
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('product_name', 'like', "%{$term}%")
                ->orWhere('composition', 'like', "%{$term}%")
                ->orWhere('dosage', 'like', "%{$term}%")
                ->orWhere('category', 'like', "%{$term}%");
        });
    }
}
