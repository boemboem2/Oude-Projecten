@extends('includes.master')

@section('content')

    <section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">

        <div class="row" style="background-color:rgba(0,0,0,0.7);">
            <div class="container">
                <form action="{{action('FrontEndController@search')}}" method="post" style="padding: 10% 10% 10% 10%;">
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


    <div id="wrapper" class="go-section">
        <div class="row">
            <div class="container">
                <h2 class="text-center">{{$pagename}}</h2>
                <hr>
                <div class="gocover"></div>
                <div id="alldocs">
                    @foreach($allusers as $alluser)
                        <div class="col-md-3 col-xs-12 col-sm-6 single">
                            <div class="group">
                                <a href="{{url('/')}}/profile/{{$alluser->id}}/{{$alluser->name}}">
                                    @if($alluser->photo != "")
                                        <img src="{{url('/')}}/assets/images/profile_photo/{{$alluser->photo}}" style="max-width: 100%;" class="profile-image" alt="">
                                    @else
                                        <img src="{{url('/')}}/assets/images/profile_photo/avatar.jpg" style="max-width: 100%;" class="profile-image" alt="{{$alluser->name}}">
                                    @endif
                                    <div class="text-center listing">
                                        <h3 class="no-margin go-bold">{{$alluser->name}}</h3>
                                        <p class="no-margin">{{$alluser->category}}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    <div class='col-md-12 margintop'></div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('footer')

@stop