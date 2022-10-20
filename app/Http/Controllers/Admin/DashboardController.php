<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;


class DashboardController extends Controller
{
    public function index()
    {
        // $now=Carbon::now();
        // $ago=$now->subDays(1);
        return Inertia::render('Dashboard/Index',[
            'users_count'=>User::all()->count(),
            'roles_count'=>Role::all()->count(),
            'permissions_count'=>Permission::all()->count(),
            // 'admins'=>User::where('is_admin',1)->count()
        ]);
    }
}
