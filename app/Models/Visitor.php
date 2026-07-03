<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'session_id', 'ip_address', 'user_agent', 'platform', 'browser',
        'device', 'country', 'city', 'url', 'referrer', 'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('visited_at', [now()->startOfMonth(), now()->endOfMonth()]);
    }
}
