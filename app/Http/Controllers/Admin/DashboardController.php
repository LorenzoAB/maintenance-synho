<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\Prevenmaintenance;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $totalAllUsers = User::count();
        $totalUser = User::where('role_as', '0')->count();
        $totalAdmin = User::where('role_as', '1')->count();

        $todayDate = Carbon::today();
        $thisMonth = Carbon::now()->format('m');
        $thisYear = Carbon::now()->format('Y');

        $totalMaintenance = Maintenance::count();
        $todayMaintenance = Maintenance::whereDate('created_at', $todayDate)->count();
        $thisMonthMaintenance = Maintenance::whereMonth('created_at', $thisMonth)->count();
        $thisYearMaintenance = Maintenance::whereYear('created_at', $thisYear)->count();

        
        $totalPrevenmaintenance = Prevenmaintenance::count();
        $todayPrevenmaintenance = Prevenmaintenance::whereDate('created_at', $todayDate)->count();
        $thisMonthPrevenmaintenance = Prevenmaintenance::whereMonth('created_at', $thisMonth)->count();
        $thisYearPrevenmaintenance = Prevenmaintenance::whereYear('created_at', $thisYear)->count();

        return view('admin.dashboard', compact('totalMaintenance', 'todayMaintenance', 'thisMonthMaintenance','thisYearMaintenance', 'totalAllUsers', 'totalUser', 'totalAdmin','totalPrevenmaintenance','todayPrevenmaintenance','thisMonthPrevenmaintenance','thisYearPrevenmaintenance'));
    }
}

