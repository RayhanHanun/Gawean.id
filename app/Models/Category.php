<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    // Relationships
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'category_id', 'id');
    }

    // Generate new ID
    public static function generateId(): string
    {
        $lastCategory = self::orderBy('id', 'desc')->first();

        if ($lastCategory) {
            $lastNumber = (int) substr($lastCategory->id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'CAT' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Get job count
    public function getJobCountAttribute(): int
    {
        return $this->jobs()->count();
    }
}
