<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cron\CronExpression;

class BackupSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'frequency',
        'cron_expression',
        'is_enabled',
        'database_options',
        'codebase_options',
        'last_run_at',
        'next_run_at',
        'last_status',
        'last_error',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'database_options' => 'array',
        'codebase_options' => 'array',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
    ];

    /**
     * Get backups for this schedule.
     */
    public function backups(): HasMany
    {
        return $this->hasMany(Backup::class);
    }

    /**
     * Get the cron expression for this schedule.
     */
    public function getCronExpression(): string
    {
        if ($this->frequency === 'custom' && $this->cron_expression) {
            return $this->cron_expression;
        }

        return match ($this->frequency) {
            'minutely' => '* * * * *',
            'hourly' => '0 * * * *',
            'daily' => '0 0 * * *',
            'weekly' => '0 0 * * 0',
            'monthly' => '0 0 1 * *',
            default => '0 0 * * *', // daily default
        };
    }

    /**
     * Calculate next run time based on cron expression.
     */
    public function calculateNextRun(): \DateTime
    {
        $cron = CronExpression::factory($this->getCronExpression());
        $now = new \DateTime();
        return $cron->getNextRunDate($now);
    }

    /**
     * Check if schedule should run now.
     */
    public function shouldRun(): bool
    {
        if (!$this->is_enabled) {
            return false;
        }

        if (!$this->next_run_at) {
            return true;
        }

        return $this->next_run_at->isPast();
    }

    /**
     * Update next run time.
     */
    public function updateNextRun(): void
    {
        $this->next_run_at = $this->calculateNextRun();
        $this->save();
    }
}

