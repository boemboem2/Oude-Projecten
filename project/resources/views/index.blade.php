@extends('includes.master')

@section('content')

<section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
    <div class="row" style="background-color:rgba(0,0,0,0.7);">
        <div class="container">
            <form action="{{action('FrontEndController@search')}}" method="post" style="padding: 20% 10% 20% 10%;">
            {{csrf_field()}}
            <div class="form-group">
                <div class="col-md-3 opt-form">
                    <input id="color" name="city" class="form-control" placeholder="Enter City" list="cities" autocomplete="off" required>
                    <datalist id="cities">
                        @foreach($cities as $city)
                            <option value="{{$city->city}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-6 opt-form">
                    <input type="text" placeholder="Enter Category" list="categories" name="category" class="form-control" autocomplete="off" required>
                    <datalist id="categories">
                        @foreach($categories as $category)
                            <option value="{{$category->name}}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-3 opt-form">
                    <button class="btn btn-ocean btn-block" type="submit">Search</button>
                </div>
            </div>
            </form>
        </div>
  </div>
</section>

<section class="go-section">
    <div class="row">
        <div class="container">
            <h2 class="text-center">All Available Sectors</h2>
            <hr>
            @foreach($categories as $category)
            <div class="col-md-4 cats">
               <a href="category/{{$category->slug}}" class="btn btn-genius btn-block"><strong> {{$category->name}}</strong></a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div id="wrapper" class="go-section">
    <div class="row">
        <div class="container">
            <h2 class="text-center">Featured Photographers</h2>
            <hr>
            @foreach($featured as $feature)
            <div class="col-md-3 col-xs-12 col-sm-6 single">
                <div class="group">
                <a href="{{url('/')}}/profile/{{$feature->id}}/{{$feature->name}}">
                    <img src="assets/images/profile_photo/{{$feature->photo}}" class="profile-image" alt="Test Lawyers">
                    <div class="text-center listing">
                        <h3 class="no-margin go-bold">{{$feature->name}}</h3>
                        <p class="no-margin">{{$feature->category}}</p>
                    </div>
                </a>
                </div>
            </div>
            @endforeach
            <div class="text-center">
                <a href="{{url('/listfeatured')}}" class="btn btn-default margintop"><strong>All Featured</strong></a>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')

@stop