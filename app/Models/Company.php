<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'company_name',
        'description',
        'address',
        'website',
        'status_verifikasi',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'company_id', 'id');
    }

    // Generate new ID
    public static function generateId(): string
    {
        $lastCompany = self::orderBy('id', 'desc')->first();

        if ($lastCompany) {
            $lastNumber = (int) substr($lastCompany->id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'CMP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_verifikasi', 'approved');
    }

    public function isApproved(): bool
    {
        return $this->status_verifikasi === 'approved';
    }
}
