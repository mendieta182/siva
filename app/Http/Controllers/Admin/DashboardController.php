<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class DashboardController extends Controller
{
    public function index()
    {
        // $now=Carbon::now();
        // $ago=$now->subDays(1);
        return Inertia::render('Dashboard/Index',[
            'users_count'=>User::all()->count(),
            // 'rolesCount'=>Role::all()->count(),
            // 'permissionsCount'=>Permission::all()->count(),
            // 'admins'=>User::where('is_admin',1)->count()
        ]);
    }
}
