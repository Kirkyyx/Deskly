<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $tickets = Ticket::where('user_id', $userId)->get();

        $stats = [
            'total'       => $tickets->count(),
            'open'        => $tickets->where('status', 'open')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'resolved'    => $tickets->where('status', 'resolved')->count(),
            'closed'      => $tickets->where('status', 'closed')->count(),
            'high'        => $tickets->where('priority', 'high')->count(),
        ];

        $recentTickets = Ticket::with(['category', 'technician'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentTickets'));
    }
}