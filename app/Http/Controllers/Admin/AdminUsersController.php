<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\UsersRequest;
use Validator;
use Illuminate\Support\Str;


class AdminUsersController extends Controller
{
    public function __construct() {
        $this->middleware('IsAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view("admin.users.index", compact("users"));
    }

    public function profile()
    {
        $user = Auth::user();
        return view("admin.users.profile", compact("user"));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','id')->all();
        return view("admin.users.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|min:8|max:255',
        ]);

        $user = User::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'password'  =>  Hash::make($request->password),
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->users()->save($user);
        
        return redirect()->route('admin.users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "method show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','id')->all();
        if(Auth::user()->isAdmin()) {
            $user->loggedInUserIsAdmin = true;
        }
        $user->page = "edit";
        return view('admin.users.profile',compact("user"),compact("roles"));
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
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required','max:255',Rule::unique('users')->ignore($user->id),],
            'email' => ['required','email','max:255',Rule::unique('users')->ignore($user->id),],
            'phone' => 'nullable|regex:/[0-9-]{9}/|min:10|max:11',
            'city' => 'max:255',
            'zipcode' => 'max:7',
            'password' => 'max:255',
            'password2' => 'same:password',
            'dateofbirth' => 'nullable|date',
        ]);
        
        if ($validator->fails()) {
            return redirect($request->path() . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        /* Notification preferences
        *  For notifications we require a comma seperated list
        *  This list should always contain database since without it we cannot save to the database notifications table
        *  Future notification preferences need to be added after a comma: database,mail,etc
        *  These values are used in the notification classes
        */ 
        $notificationPreferences = explode(',',$user->notification_preference);
        if($request->emailNotifications) {
            if(!in_array('mail',$notificationPreferences)) array_push($notificationPreferences,'mail');
        } else {
            if(in_array('mail',$notificationPreferences)) array_splice($notificationPreferences,array_search('mail',$notificationPreferences));
        }
        $user->notification_preference = implode(',',$notificationPreferences);
        
        //set dateofbirth and prevent empty
        if(!empty($request->dateofbirth)) {
            $date = \Carbon\Carbon::parse($request->dateofbirth, 'Europe/Amsterdam');
            $request->merge([ 'dateofbirth' => $date ]);
        } else {
            $request->merge([ 'dateofbirth' => $user->dateofbirth ]);
        }

        //set role if exists
        if($request->role) {
            $role = Role::findOrFail($request->role);
            $role->users()->save($user);
        }

        //prevent deletion of password
        if ($request->get('password') == '') {
            $user->update($request->except('password'));
        } else {
            $request->merge([ 'password' => Hash::make($request->password) ]);
            $user->update($request->all());
        }

        

        if($request->page == "profile") {
            return redirect()->route('admin.users.profile');
        } else {
            return redirect()->route('admin.users');
        }

        



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users');
    }

    function logout() {
        Auth::logout();
        return Redirect::to('login');
    }




}
