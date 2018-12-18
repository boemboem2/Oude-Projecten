<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //$users = UsersModel::all();
        $users = UsersModel::orderBy('id', 'DESC')->get();
        return view('admin.userslist', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::select('select * from category');
        return view('admin.useradd', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = new UsersModel;
        $data->fill($request->all());
        $pass = Hash::make(str_random(6));
        $data->qtitles = implode (", ", $request->q_titles);
        $data->qualifications = implode (", ", $request->qualities);
        $data->password = $pass;

        if ($file = $request->file('photo')){
            $photo_name = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/profile_photo',$photo_name);
            $data['photo'] = $photo_name;
        }
        $data['status'] = 1;
        $data->save();
        $lastid = $data->id;

        if ($files = $request->file('gallery')){
            foreach ($files as $file){
                $gallery = new Gallery;
                $image_name = str_random(2).time().$file->getClientOriginalName();
                $file->move('assets/images/gallery',$image_name);
                $gallery['image'] = $image_name;
                $gallery['userid'] = $lastid;
                $gallery->save();
            }
        }

        $msg = "Dear User, Your Account Created Successfully. You can Login now.\nYour Login Url: ".url('/')."Use Your Password: ".$pass;
        mail($request->email,"Your Account Has Created",$msg);

        Session::flash('message', 'Added Successfully.');
        return redirect('admin/users');
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
        $categories = DB::select('select * from category');
        UsersModel::$withoutAppends = true;
        $user = UsersModel::findOrFail($id);
        return view('admin.useredit', compact('user','categories'));
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
        $user = UsersModel::findOrFail($id);
        $input = $request->all();
        $input['qtitles'] = implode (", ", $request->q_titles);
        $input['qualifications'] = implode (", ", $request->qualities);

        if ($file = $request->file('photo')){
            $photo_name = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/profile_photo',$photo_name);
            $input['photo'] = $photo_name;
        }

        if ($request->galdel == 1){
            $gal = Gallery::where('userid',$id);
            $gal->delete();
        }

        if ($files = $request->file('gallery')){
            foreach ($files as $file){
                $gallery = new Gallery;
                $image_name = str_random(2).time().$file->getClientOriginalName();
                $file->move('assets/images/gallery',$image_name);
                $gallery['image'] = $image_name;
                $gallery['userid'] = $id;
                $gallery->save();
            }
        }
        $user->update($input);
        Session::flash('message', 'Updated Successfully.');
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = UsersModel::findOrFail($id);
        $user->delete();
        Session::flash('message', 'Deleted Successfully.');
        return redirect('admin/users');
    }
}
