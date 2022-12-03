<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Category;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::where('project_id',auth()->user()->selected_project_id)->get();

        // dd($categories);

        return Inertia::render('Incidents/Index', [
            'categories' => $categories,
            // 'search' => $search,
            // 'email_search' => $email_search,
            // 'perPage'=>$perPage,
            // 'filters' => $request->only(['search','perPage','email_search'])
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
        // dd(auth()->user()->selected_project_id);
        $this->validate($request,[
            'severity'=>'required|in:A,N,B',
            'title'=>'required|min:2',
            'description'=>'required|min:2'
        ]);

        Incident::create([
            'category_id'=>$request->category_id,
            'severity'=>$request->severity,
            'title'=>$request->title,
            'description'=>$request->description,
            'client_id'=>auth()->user()->id,
            'project_id'=>auth()->user()->selected_project_id,
            'level_id'=>Project::find(auth()->user()->selected_project_id)->first_level_id
            // 'client_id'=>auth()->user()->id,
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
    public function destroy($id)
    {
        //
    }

    public function attend($id)
    {
        $incident = Incident::findOrFail($id);
        $incident->support_id = auth()->user()->id;
        $incident->save();

        return back();
    }
}
