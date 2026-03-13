<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        $attempts = AuditLog::where('action', 'login')
            ->where('status', 'failed')
            ->where('ip_address', request()->ip())
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count() + 1;

        AuditLog::create([
            'user_id'         => $event->user?->id,
            'action'          => 'login',
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
            'status'          => 'failed',
            'email_attempted' => $event->credentials['email'] 
                                 ?? $event->credentials['username'] 
                                 ?? $event->credentials['login'] 
                                 ?? null,
            'failed_attempts' => $attempts,
        ]);
    }
}