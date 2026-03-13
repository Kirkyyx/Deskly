<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::id();

        $totalAssigned  = Ticket::where('technician_id', $staffId)->count();
        $inProgress     = Ticket::where('technician_id', $staffId)->where('status', 'in_progress')->count();
        $resolved       = Ticket::where('technician_id', $staffId)->where('status', 'resolved')->count();
        $highPriority   = Ticket::where('technician_id', $staffId)
                                ->whereIn('status', ['open', 'in_progress'])
                                ->whereIn('priority', ['high', 'critical'])
                                ->count();

        $recentTickets  = Ticket::with('user')
                                ->where('technician_id', $staffId)
                                ->latest('updated_at')
                                ->take(8)
                                ->get();

        return view('staff.dashboard', compact(
            'totalAssigned',
            'inProgress',
            'resolved',
            'highPriority',
            'recentTickets'
        ));
    }
}