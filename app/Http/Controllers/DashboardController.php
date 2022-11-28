<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Incident;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;


class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $my_incidents = Incident::with('category')
                                ->where('project_id',$user->selected_project_id)
                                ->where('support_id',$user->id)->get();

        $projectUser = ProjectUser::where('project_id',$user->selected_project_id)
                                  ->where('user_id',$user->id)->first();
        // dd($projectUser->level_id);
        $pending_incidents = Incident::with('category')
                                     ->where('support_id',null)
                                     ->where('level_id',$projectUser->level->id)->get();

        $incidents_by_me = Incident::with('category')
                                   ->where('client_id',$user->id)
                                   ->where('project_id',$user->selected_project_id)->get();
        // $now=Carbon::now();
        // $ago=$now->subDays(1);
        return Inertia::render('Dashboard/Index',[
            'users_count'=>User::all()->count(),
            'roles_count'=>Role::all()->count(),
            'permissions_count'=>Permission::all()->count(),
            'my_incidents'=> $my_incidents,
            'pending_incidents'=>$pending_incidents,
            'incidents_by_me'=>$incidents_by_me
            // 'admins'=>User::where('is_admin',1)->count()
        ]);
    }
}
