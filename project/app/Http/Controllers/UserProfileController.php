<?php

namespace App\Http\Controllers;

use App\Category;
use App\Profile;
use App\User;
use App\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:profile');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = UsersModel::findOrFail(Auth::user()->id);
        return view('user.dashboard',compact('user'));
    }

    //Show Change Password Form
    public function changePassform()
    {
        return view('user.changepass');
    }

    //Edit Profile Form
    public function edit()
    {
        UsersModel::$withoutAppends = true;
        $categories = Category::all();
        $user = UsersModel::find(Auth::user()->id);
        return view('user.editprofile',compact('user','categories'));
    }

    //Update Profile
    public function update(Request $request, $id)
    {
        $user = UsersModel::findOrFail($id);
        $input = $request->all();

        $input['qtitles'] = implode (", ", $request->q_titles);
        $input['qualifications'] = implode (", ", $request->qualities);

        if ($file = $request->file('photo')){
            $photo_name = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/profile_photo',$photo_name);
            $input['photo'] = $photo_name;
        }

        $user->update($input);
        Session::flash('message', 'Profile Updated Successfully.');
        return redirect('user/edit');
    }
    //Update Profile
    public function publish($id)
    {
        $user = Profile::findOrFail($id);
        $input['status'] = 1;

        $user->update($input);
        Session::flash('message', 'Your Profile Published Successfully.');
        return redirect('user/dashboard');
    }

    //Change User Password
    public function changepass(Request $request, $id)
    {
        $user = Profile::findOrFail($id);
        $input['password'] = "";
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){

                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    Session::flash('error', 'Confirm Password Does not match.');
                    return redirect('user/changepassword');
                }
            }else{
                Session::flash('error', 'Current Password Does not match');
                return redirect('user/changepassword');
            }
        }

        $user->update($input);
        Session::flash('message', 'Account Password Updated Successfully.');
        return redirect('user/changepassword');
    }
}
