<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SharedTable extends Model
{
    protected $fillable = ['slug', 'title', 'json_data', 'expires_at'];

    protected function casts(): array
    {
        return [
            'json_data'  => 'array',
            'expires_at' => 'datetime',
        ];
    }

    public static function booted(): void
    {
        static::creating(function (SharedTable $table) {
            if (empty($table->slug)) {
                $table->slug = Str::random(20);
            }
            if (empty($table->expires_at)) {
                $table->expires_at = Carbon::now()->addHours(24);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('expires_at', '>', Carbon::now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getUrl(): string
    {
        return route('shared-table', $this->slug);
    }

    public function getColumns(): array
    {
        $cols = [];
        foreach ($this->json_data as $row) {
            if (is_array($row)) {
                foreach (array_keys($row) as $key) {
                    $cols[$key] = true;
                }
            }
        }

        return array_keys($cols);
    }
}
