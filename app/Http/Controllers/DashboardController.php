<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LetterRequest;
use App\Models\News;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $stats = [];

        if ($user->isAdmin()) {
            $stats = [
                'pending_users' => User::where('is_verified', false)->count(),
                'total_users' => User::where('role', 'user')->count(),
                'total_letters' => LetterRequest::count(),
                'pending_letters' => LetterRequest::whereIn('status', ['pending_rt', 'pending_rw'])->count(),
                'approved_letters' => LetterRequest::where('status', 'approved_final')->count(),
                'total_news' => News::count(),
                'published_news' => News::where('status', 'published')->count(),
            ];
        } elseif ($user->isRT()) {
            $stats = [
                'pending_letters' => LetterRequest::where('status', 'pending_rt')
                    ->whereHas('user', function($query) use ($user) {
                        $query->where('rt_rw', 'like', '%' . explode('/', $user->rt_rw)[0] . '%');
                    })->count(),
                'approved_letters' => LetterRequest::where('status', '!=', 'pending_rt')
                    ->whereHas('user', function($query) use ($user) {
                        $query->where('rt_rw', 'like', '%' . explode('/', $user->rt_rw)[0] . '%');
                    })->count(),
            ];
        } elseif ($user->isRW()) {
            $stats = [
                'pending_letters' => LetterRequest::where('status', 'pending_rw')
                    ->whereHas('user', function($query) use ($user) {
                        $query->where('rt_rw', 'like', '%' . explode('/', $user->rt_rw)[0] . '%');
                    })->count(),
                'approved_letters' => LetterRequest::where('status', 'approved_final')
                    ->whereHas('user', function($query) use ($user) {
                        $query->where('rt_rw', 'like', '%' . explode('/', $user->rt_rw)[0] . '%');
                    })->count(),
            ];
        } else {
            $stats = [
                'total_requests' => $user->letterRequests()->count(),
                'pending_requests' => $user->letterRequests()->whereIn('status', ['pending_rt', 'pending_rw'])->count(),
                'approved_requests' => $user->letterRequests()->where('status', 'approved_final')->count(),
                'rejected_requests' => $user->letterRequests()->whereIn('status', ['rejected_rt', 'rejected_rw'])->count(),
            ];
        }

        // Get recent news for all users
        $recentNews = News::published()->latest()->take(3)->get();

        return view('dashboard', compact('stats', 'recentNews'));
    }
}
