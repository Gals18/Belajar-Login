<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(User $user)
    {
        // DB::connection()->enableQueryLog();
        $data = $user::all();
        $userSession = [
            "id" => session('id'),
            "name" => session('name'),
            "level" => session('level'),
        ];
        return view('Dashboard.prosesleveling', compact('userSession', 'data'));
    }
}
