<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        AuditLog::create([
            'user_id'    => $event->user->id,
            'action'     => 'login',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status'     => 'success',
        ]);
    }
}