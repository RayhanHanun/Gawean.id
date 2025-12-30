<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'job_id',
        'user_id',
        'apply_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'apply_date' => 'date',
        ];
    }

    // Relationships
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Generate new ID
    public static function generateId(): string
    {
        $lastApplication = self::orderBy('id', 'desc')->first();

        if ($lastApplication) {
            $lastNumber = (int) substr($lastApplication->id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'APP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInterview($query)
    {
        return $query->where('status', 'interview');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helpers
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'interview' => 'badge-info',
            'accepted' => 'badge-success',
            'rejected' => 'badge-error',
            default => 'badge-ghost'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'interview' => 'Interview',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }
}
