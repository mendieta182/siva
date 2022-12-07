<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
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

        $categories=Category::where('project_id',auth()->user()->selected_project_id)->get();

        $my_incidents = Incident::with(['category','project','support','client','level'])
                                ->where('project_id',$user->selected_project_id)
                                ->where('support_id',$user->id)->get();

        // dd($user->roles[0]['name'] == 'client');

        $projectUser = ProjectUser::where('project_id',$user->selected_project_id)
                                  ->where('user_id',$user->id)->first();

        
        // dd($projectUser->level_id);
        if ($projectUser) {           

            $pending_incidents = Incident::with(['category','project','support','client','level'])
                                     ->where('support_id',null)
                                     ->where('level_id',$projectUser->level->id)->get();
        }
        else {
            $pending_incidents = Incident::with(['category','project','support','client','level'])
                                     ->where('support_id',null);
        }
        

        $incidents_by_me = Incident::with(['category','project','support','client','level'])
                                   ->where('client_id',$user->id)
                                   ->where('project_id',$user->selected_project_id)->get();
        
        return Inertia::render('Dashboard/Index',[
            'users_count'=>User::all()->count(),
            'roles_count'=>Role::all()->count(),
            'permissions_count'=>Permission::all()->count(),
            'my_incidents'=> $my_incidents,
            'pending_incidents'=>$pending_incidents ? $pending_incidents:'no hay datos',
            'incidents_by_me'=>$incidents_by_me,
            'categories'=>$categories
        ]);
    }
}
