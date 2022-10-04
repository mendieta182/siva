<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->has('search') ? $request->search : '';

        $email_search = $request->has('email_search') ? $request->email_search : '';
        
        $perPage = $request->has('perPage') ? $request->perPage : '5';



        $users = User::where('name','LIKE','%'.$search.'%')
                       ->orwhere('email','LIKE','%'.$search.'%')
                       ->paginate($perPage)->withQueryString();
        return Inertia::render('Users/Index', [
            'users' => $users,
            'search' => $search,
            'email_search' => $email_search,
            'perPage'=>$perPage,
            'filters' => $request->only(['search','perPage','email_search'])
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
            'name'=>['required','max:50','min:2'],
            'lastname'=>['required','max:50','min:2'],
            // 'roles'=>['required'],
            'email'=>['required','max:50','min:2','email','unique:users,email']
        ]);
        $user=User::create([
            'name'=>$request->name,
            'lastname'=>$request->lastname,
            'email'=>$request->email,
            'status'=>0,
            'password'=>Hash::make('password'),
        ]);
        // if ($request->has('roles')){
        //     $user->assignRole($request->roles);
        // }

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
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    public function activate(User $user)
    {
        $user->status=1;
        $user->save();
        return back();
    }
    public function inactivate(User $user)
    {
        $user->status=0;
        $user->save();
        return back();
    }
}
