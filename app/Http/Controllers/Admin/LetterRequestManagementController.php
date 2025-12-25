<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterRequest;
use Illuminate\Http\Request;

class LetterRequestManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = LetterRequest::with(['user.biodata', 'letterType', 'approvals.approver', 'subject']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by request number or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => LetterRequest::count(),
            'pending_rt' => LetterRequest::where('status', 'pending_rt')->count(),
            'pending_rw' => LetterRequest::where('status', 'pending_rw')->count(),
            'approved' => LetterRequest::where('status', 'approved_final')->count(),
            'rejected' => LetterRequest::whereIn('status', ['rejected_rt', 'rejected_rw'])->count(),
        ];

        return view('admin.letter-requests.index', compact('requests', 'stats'));
    }

    public function show(LetterRequest $letterRequest)
    {
        $letterRequest->load(['user.biodata', 'letterType', 'approvals.approver', 'subject']);
        
        return view('admin.letter-requests.show', compact('letterRequest'));
    }
}
