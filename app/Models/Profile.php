<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'phone_number',
        'skills',
        'cv_file',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Generate new ID
    public static function generateId(): string
    {
        $lastProfile = self::orderBy('id', 'desc')->first();

        if ($lastProfile) {
            $lastNumber = (int) substr($lastProfile->id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'PRF' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Get skills as array
    public function getSkillsArrayAttribute(): array
    {
        return $this->skills ? explode(', ', $this->skills) : [];
    }
}
