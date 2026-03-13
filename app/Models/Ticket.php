<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id',
        'status',
        'priority',
        'technician_id',
    ];

    /**
     * The user who submitted this ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The IT staff member assigned to this ticket.
     * Kept as `technician()` for DB/relationship compatibility,
     * but aliased as `itStaff()` for cleaner Blade usage.
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /**
     * Alias of technician() — use $ticket->itStaff in views
     * wherever you want to display "IT Staff".
     */
    public function itStaff()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // ── Status helpers ────────────────────────────────────────

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['open', 'in_progress']);
    }

    /**
     * Human-readable status label.
     */
    public function statusLabel(): string
    {
        return match($this->status) {
            'in_progress' => 'In Progress',
            default       => ucfirst($this->status),
        };
    }
}