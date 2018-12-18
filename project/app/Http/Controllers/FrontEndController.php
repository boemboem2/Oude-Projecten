<?php

namespace App\Http\Controllers;

use App\Category;
use App\Gallery;
use App\PageSettings;
use App\Review;
use App\Subscribers;
use App\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontEndController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = UsersModel::distinct()->get(['city']);
        $categories = Category::all();
        $featured = UsersModel::where('featured', 1)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();
        return view('index', compact('featured','categories','cities'));
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
        //
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

    //Profile Data
    public function viewprofile($id)
    {
        $profiledata = UsersModel::findOrFail($id);
        $reviews = Review::where('userid',$id)->get();
        $gallerydata = Gallery::where('userid',$id)->get();
        return view('profile', compact('profiledata','reviews','gallerydata'));
    }

    //Contact Page Data
    public function contact()
    {
        $pagedata = PageSettings::find(1);
        return view('contact', compact('pagedata'));
    }

    //About Page Data
    public function about()
    {
        $pagedata = PageSettings::find(1);
        return view('about', compact('pagedata'));
    }

    //FAQ Page Data
    public function faq()
    {
        $pagedata = PageSettings::find(1);
        return view('faq', compact('pagedata'));
    }

    //Show All Users
    public function all()
    {
        $cities = UsersModel::distinct()->get(['city']);
        $categories = Category::all();
        $allusers = UsersModel::where('status', 1)
            ->orderBy('name', 'asc')->get();
        $pagename = "All Photographers";
        return view('listall', compact('allusers','pagename','categories','cities'));
    }

    //Show Featured Users
    public function featured()
    {
        $cities = UsersModel::distinct()->get(['city']);
        $categories = Category::all();
        $allusers = UsersModel::where('featured', 1)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        $pagename = "Featured Photographers";
        return view('listall', compact('allusers','pagename','categories','cities'));
    }

    //Show Category Users
    public function category($category)
    {
        $cities = UsersModel::distinct()->get(['city']);
        $categories = Category::all();
        $allusers = UsersModel::where('status', 1)
            ->where('category', $category)
            ->get();
        $pagename = "All Photographers in: ".ucwords($category);
        return view('listall', compact('allusers','pagename','categories','cities'));
    }

    //Submit Review
    public function reviewsubmit(Request $request)
    {
        $review = new Review;
        $review->fill($request->all());
        $review['review_date'] = date('Y-m-d H:i:s');
        $review->save();
        return redirect()->back()->with('message','Your Review Submitted Successfully.');
    }

    //Show Searched Users
    public function search(Request $request)
    {
        $cities = UsersModel::distinct()->get(['city']);
        $categories = Category::all();
        $allusers = UsersModel::where('status', 1)
            ->where('category', $request->category)
            ->where('city', $request->city)
            ->get();
        $pagename = "Search Result For: ".$request->category." in ".$request->city;
        return view('listall', compact('allusers','pagename','categories','cities'));
    }

    //User Subscription
    public function subscribe(Request $request)
    {
        $subscribe = new Subscribers;
        $subscribe->fill($request->all());
        $subscribe->save();
        Session::flash('subscribe', 'You are subscribed Successfully.');
        return redirect('/');
    }

    //Send email to user
    public function usermail(Request $request)
    {
        $subject = "Contact From Of Handymen";
        $to = $request->to;
        $name = $request->name;
        $from = $request->email;
        $msg = $request->message;

        mail($to,$subject,$msg);

        return redirect('/');
    }
    //Send email to Admin
    public function contactmail(Request $request)
    {
        $pagedata = PageSettings::findOrFail(1);
        $subject = "Contact From Of Handymen";
        $to = $request->to;
        $name = $request->name;
        $from = $request->email;
        $msg = $request->message;

        mail($to,$subject,$msg);

        Session::flash('cmail', $pagedata->contact);
        return redirect('/contact');
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
}
