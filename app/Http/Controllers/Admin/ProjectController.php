<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Level;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->has('search') ? $request->search : '';
        $perPage = $request->has('perPage') ? $request->perPage : 5;

        $projects=Project::withTrashed()->where('name','LIKE','%'.$search.'%')
                           ->orwhere('description','LIKE','%'.$search.'%')
        ->paginate($perPage)->withQueryString();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'search' => $search,
            'perPage'=>$perPage,
        ]);
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
        $this->validate($request,[
            'name'=>['required','max:25','min:5','unique:projects,name'],
            'description'=>['required','min:5'],
        ]);
        $permission=Permission::create([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

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
    public function edit(Project $project)
    {
        $categories = Category::where('project_id',$project['id'])->withTrashed()->get();
        $levels = Level::where('project_id',$project['id'])->withTrashed()->get();
        // ->withTrashed()->get()
        // dd($project);
        return Inertia::render('Projects/Edit',[
            'project' => $project,
            // 'categories' => $project->categories,
            'categories' => $categories,
            'levels' => $levels
            // 'levels' => $project->levels
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->validate($request,[
            'name'=>['required','max:25','min:5',Rule::unique('projects')->ignore($project->id)],
            'description'=>['required','min:5']
        ]);

        $project->update([
            'name'=>strtolower($request->name),
            'description'=>strtolower($request->description)
        ]);

        // return redirect()->route('admin.projects.index');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return back();
    }

    public function restore($id)
    {
        $project = Project::withTrashed()->find($id);
        $project->restore();
        return back();
    }
}
