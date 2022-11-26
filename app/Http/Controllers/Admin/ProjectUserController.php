<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->All());
        $project_user = ProjectUser::where('project_id',$request->project_id)
                                        ->where('user_id',$request->user_id)->first();

        $this->validate($request,[
            'project_id'=>'required|exists:projects,id',
            'user_id'=>'required|exists:users,id',
            'level_id'=>'required|exists:levels,id'
        ]);
        
        

        if ($project_user) 
            return back();
        
        $user = User::findOrFail($request->user_id);
        $user->selected_project_id=$request->project_id;
        $user->save();

        ProjectUser::create([
            'project_id'=>$request->project_id,
            'user_id'=>$request->user_id,
            'level_id'=>$request->level_id
        ]);

        // dd($request->project_id);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectUser $project_user)
    {
        $user = User::find($project_user->user_id);

        if (count($user->projects)>1) {

            if ($user->selected_project_id > $project_user->project_id) {
                $project_user->delete();
                return back();
            }
            elseif ($user->selected_project_id < $project_user->project_id) {
                $project_user->delete();
                return back();
            }
            elseif ($user->selected_project_id = $project_user->project_id) {
               
                $project_user->delete();
                $user1 = User::find($project_user->user_id);
                $user->selected_project_id = $user1->projects->first()->id ;
            }
        }
        
        elseif (count($user->projects)==1) {
            $project_user->delete();
            $user->selected_project_id=null;
        }
        
        $user->save();

        // $project_user->delete();

        return back();
    }
}
