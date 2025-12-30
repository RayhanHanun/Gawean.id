<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // Relationships
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'user_id', 'id');
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHrd(): bool
    {
        return $this->role === 'hrd';
    }

    public function isPelamar(): bool
    {
        return $this->role === 'pelamar';
    }

    // Generate new ID
    public static function generateId(string $role): string
    {
        $prefix = match($role) {
            'admin' => 'ADM',
            'hrd' => 'HRD',
            'pelamar' => 'PLM',
            default => 'USR'
        };

        $lastUser = self::where('id', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastUser) {
            $lastNumber = (int) substr($lastUser->id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
