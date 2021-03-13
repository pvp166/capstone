<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;
/*
    |--------------------------------------------------------------------------
    | Users Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling admin users page
    |
*/

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function index()
    {
        $users = User::all();

        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $users = User::where('id', $user)->first();
        $users->delete();
        $users = User::all();
        return view('admin.users.index')->with('users', $users);
    }
    /**
     * Filter to get a specified user by three criteria: name, email and role
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $users = [];
        // check if name is not null
        if (!is_null($request->name)) {
            //check if email is not null
            if (!is_null($request->email)) {
                //check if users want all kind of roles
                if ($request->role == "all") {
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.name', 'like', '%' . $request->name . '%')
                        ->where('users.email', 'like', '%' . $request->email . '%')
                        //->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                }
                //check if users want a kind of roles
                else {
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.name', 'like', '%' . $request->name . '%')
                        ->where('users.email', 'like', '%' . $request->email . '%')
                        ->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                }
            } // end if(!is_null($request->email))
            //check if email is null
            else {
                //check if users want all kind of roles
                if ($request->role == "all") {
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.name', 'like', '%' . $request->name . '%')
                        //->where('users.email','like', '%'.$request->email.'%')
                        //->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                }
                //check if users want a kind of roles
                else {
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.name', 'like', '%' . $request->name . '%')
                        //->where('users.email','like', '%'.$request->email.'%')
                        ->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                }
            } // end if(!is_null($request->email))
        } //end if(!is_null($request->name))

        // check if name is not null
        else {
            //check if email is not null
            if (!is_null($request->email)) {
                //check if users want all kind of roles
                if ($request->role == "all") {
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        //->where('users.name','like', '%'.$request->name.'%')
                        ->where('users.email', 'like', '%' . $request->email . '%')
                        //->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                } else {
                    //check if users want a kind of roles
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        //->where('users.name','like', '%'.$request->name.'%')
                        ->where('users.email', 'like', '%' . $request->email . '%')
                        ->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                } // end if(!is_null($request->email))
            }
            //check if email is not null
            else {
                //check if users want all kind of roles
                if ($request->role == "all") {
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        //->where('users.name','like', '%'.$request->name.'%')
                        //->where('users.email','like', '%'.$request->email.'%')
                        //->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                } else {
                    //check if users want a kind of roles
                    $users = DB::table('users')
                        ->join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        //->where('users.name','like', '%'.$request->name.'%')
                        ->where('users.email', 'like', '%' . $request->email . '%')
                        ->where('roles.name', $request->role)
                        ->select('users.id', 'users.name', 'users.email', 'roles.name AS role')
                        ->get();
                }
            } // end if(!is_null($request->email))
        } // end if(!is_null($request->name))
        // $users = json_decode(json_encode($users), true);
        // if ($request['sortOption'] == 'name') {
        //     if ($request['direction'] == 'ascending') {
        //         $column = array_column($users, 'name');
                
        //         array_multisort($column, SORT_ASC, $users);
                
        //     } else if ($request['direction'] == 'descending') {
        //         $column = array_column($users, 'name');
        //         array_multisort($column, SORT_DESC, $users);
        //     }
        // } else if ($request['sortOption'] == 'email') {
        //     if ($request['direction'] == 'ascending') {
        //         $column = array_column($users, 'email');
                
        //         array_multisort($column, SORT_ASC, $users);
        //     } else if ($request['direction'] == 'descending') {
        //         $column = array_column($users, 'email');
        //         array_multisort($column, SORT_DESC, $users);
        //     }
        // } else if ($request['sortOption'] == 'action') {
        //     if ($request['direction'] == 'ascending') {
        //         $column = array_column($users, 'role');
                
        //         array_multisort($column, SORT_ASC, $users);
        //     } else if ($request['direction'] == 'descending') {
        //         $column = array_column($users, 'role');
        //         array_multisort($column, SORT_DESC, $users);
        //     }
        // } else if ($request['sortOption'] == 'ID') {
        //     if ($request['direction'] == 'ascending') {
        //         $column = array_column($users, 'id');
                
        //         array_multisort($column, SORT_ASC, $users);
        //     } else if ($request['direction'] == 'descending') {
        //         $column = array_column($users, 'id');
        //         array_multisort($column, SORT_DESC, $users);
        //     }
        // }
        // $list = (array)$users;
        // $array = (object) $list;
        return view('admin.users.indexfilter')->with('users', $users);
    }
    
}
