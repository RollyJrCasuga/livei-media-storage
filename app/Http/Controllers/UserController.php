<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('administrator')){
            $users = User::all();
            return view('user.index',compact('users'));
        }
        else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'account_type' => 'required',
        ]);
    
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $email = $request->get('email');
        $password = $request->get('password');
        $type = $request->get('account_type');

        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
            $user->email_verified_at = now();
            $user->save();

        switch ($type){
            case 'Admin':
                $user->assignRole('administrator');
                break;
            case 'Staff';
                $user->assignRole('staff');
                break;
        }
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(auth()->user()->hasRole('administrator')){
            return view('user.show', compact('user'));
        }
        else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'account_type' => 'required',
        ]);
    
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $password = $request->get('password');
        $type = $request->get('account_type');
        
        // dd($request);
        $user->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => Hash::make($password),
        ]);
        switch ($type){
            case 'Admin':
                $user->syncRoles('administrator');
                break;
            case 'Staff';
                $user->syncRoles('staff');
                break;
        }
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
