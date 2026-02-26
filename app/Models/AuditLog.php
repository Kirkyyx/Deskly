<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_id',
        'article_id',       // added
        'action',
        'ip_address',
        'user_agent',
        'status',
        'email_attempted',
        'failed_attempts',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function article()                           // added
    {
        return $this->belongsTo(Article::class);
    }

    public static function log(string $action, array $extras = []): void
    {
        static::create(array_merge([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status'     => 'success',
        ], $extras));
    }
}