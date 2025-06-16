<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'date',
        'status',
        'priority',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFullTextSearch(Builder $query, string $term): Builder
    {
        return $query->whereRaw("MATCH(title, description) AGAINST (? IN BOOLEAN MODE)", [$term]);
    }
}