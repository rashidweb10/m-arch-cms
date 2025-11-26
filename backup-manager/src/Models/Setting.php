<?php

namespace Marinarch\BackupManager\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'backup_manager_settings';

    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getValue(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}


