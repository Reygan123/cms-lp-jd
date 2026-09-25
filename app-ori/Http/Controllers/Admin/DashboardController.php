<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\VisitorCount;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{    
    public function index(Request $request)
    {
        $visitorId = $request->session()->getId();

        if (!$request->session()->has('visited')) {
            $request->session()->put('visited', true);

            $visitorCount = VisitorCount::where('visitor_id', $visitorId)->first();

            if ($visitorCount) {
                $visitorCount->count++;
                $visitorCount->save();
            } else {
                $visitorCount = VisitorCount::create([
                    'visitor_id' => $visitorId,
                    'count' => 1
                ]);
            }
        }

        $currentMonth = Carbon::now()->month;
        $monthlyVisitors = VisitorCount::where('created_at', '>=', Carbon::now()->subMonths(11))
            ->orderBy('created_at')
            ->get(['count', 'created_at'])
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m');
            })
            ->map(function ($item) {
                return $item->sum('count');
            });

        $monthlyVisitors = $monthlyVisitors->all();
        $yearlyCount = VisitorCount::whereYear('created_at', Carbon::now()->year)->sum('count');
        $sumVisitors = VisitorCount::sum('count');
        $sumPosts = Post::count();
        
        return view('admin.dashboard.index', compact('monthlyVisitors','yearlyCount', 'sumVisitors','sumPosts'));
    }


    
}