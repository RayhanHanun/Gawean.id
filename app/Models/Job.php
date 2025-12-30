<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'company_id',
        'category_id',
        'title',
        'description',
        'salary_range',
        'location',
        'deadline',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id', 'id');
    }

    // Generate new ID
    public static function generateId(): string
    {
        $lastJob = self::orderBy('id', 'desc')->first();

        if ($lastJob) {
            $lastNumber = (int) substr($lastJob->id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'JOB' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'open')
            ->where('deadline', '>=', now()->toDateString());
    }

    // Helpers
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isExpired(): bool
    {
        return $this->deadline < now()->toDateString();
    }

    public function getFormattedSalaryAttribute(): string
    {
        if ($this->salary_range === 'Disembunyikan' || empty($this->salary_range)) {
            return 'Gaji Dirahasiakan';
        }
        return $this->salary_range;
    }

    public function getApplicantCountAttribute(): int
    {
        return $this->applications()->count();
    }
}
