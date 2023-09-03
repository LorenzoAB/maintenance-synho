<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\Prevenmaintenance;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

        return view('home', compact('totalMaintenance', 'todayMaintenance', 'thisMonthMaintenance','thisYearMaintenance', 'totalAllUsers', 'totalUser', 'totalAdmin','totalPrevenmaintenance','todayPrevenmaintenance','thisMonthPrevenmaintenance','thisYearPrevenmaintenance'));
    }
}
