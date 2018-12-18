@extends('includes.master')

@section('content')

<section style="background: url({{url('/')}}/assets/images/{{$settings[0]->background}}) no-repeat center center; background-size: cover;">
    <div class="row" style="background-color:rgba(0,0,0,0.7);">
       
            <div style="margin: 4% 0px 4% 0px;">
                <div class="text-center" style="color: #FFF;padding: 20px;">
                    <h1>{{$profiledata->name}}</h1>
                    <div>{{$profiledata->category}}</div>
                    <div class="ratings">
                        <div class="empty-stars"></div>
                        <div class="full-stars" style="width:{{number_format((float)\App\Review::where('userid',$profiledata->id)->avg('rating'), 1, '.', '')*20}}%"></div>
                    </div>
                    <span class="rating-number">({{number_format((float)\App\Review::where('userid',$profiledata->id)->avg('rating'), 1, '.', '')}}/5)</span>
                    <div class="rating-number">({{\App\Review::where('userid',$profiledata->id)->count()}} Reviews)</div>

                </div>
            </div>
        
    </div>
</section>

<div id="wrapper" class="go-section">
    <div class="row">
        <div class="container">
            <div class="col-md-8">
                <div class="profile-section">
                    <div id="gallery" style="display:none;">
                        @foreach($gallerydata as $gallery)
                            <img alt=""
                                 src="{{url('/')}}/assets/images/gallery/{{$gallery->image}}"
                                 data-image="{{url('/')}}/assets/images/gallery/{{$gallery->image}}"
                                 data-description="">
                        @endforeach
                    </div>
                </div>
                <div class="profile-section">
                    <h3 class="no-margin">Profile Description</h3><hr>
                    {!! $profiledata->description !!}
                </div>
                <div class="profile-section">
                <div class="row">
                    <h3 class="no-margin">Interests</h3><hr>
                        <ul class="col-md-12 specialities">
                            @foreach($profiledata->specialities as $specialitie)
                                <li class="col-md-6 specialitie">{{$specialitie}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="profile-section">
                <div class="row">
                    <h3 class="no-margin">Qualifications</h3><hr>
                    <ul class="col-md-12 qualifications">
                        <li class="col-md-12 qualification">
                            <strong>Gender</strong>
                            <span>{{$profiledata->gender}}</span>
                        </li>
						@if(!empty($profiledata->qtitles))
							@foreach(array_combine($profiledata->qtitles, $profiledata->qualifications) as $title => $quality)
							<li class="col-md-12 qualification">
								<strong>{{$title}}</strong>
								<span>{{$quality}}</span>
							</li>
							@endforeach
						@endif
                    </ul>
                    </div>
                </div>
                {{-- Advertisements Size: 728x90 --}}
                <div style="margin-bottom:20px;">
                    <div class="desktop-advert">
                    @if(!empty($ads728x90))
                        @if($ads728x90->type == "banner")
                            <a class="ads" href="{{$ads728x90->redirect_url}}" target="_blank">
                                <img class="banner-728x90" src="{{url('/')}}/assets/images/ads/{{$ads728x90->banner_file}}" alt="Advertisement">
                            </a>
                        @else
                            {!! $ads728x90->script !!}
                        @endif
                    @endif
                    </div>
                </div>

                <div class="row">

                    <div id="profileTab">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a  href="#contact" data-toggle="tab">Contact</a>
                            </li>
                            <li>
                                <a href="#reviews" data-toggle="tab">Reviews</a>
                            </li>
                        </ul>

                        <div class="tab-content ">
                            <div class="tab-pane fade in active" id="contact">
                                <div class="col-md-12">
                                <h3>Contact</h3><hr>
                                <form action="{{action('FrontEndController@usermail')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" id="to" name="to" value="shaoneel@gamil.com">
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                        <p id="vname" style="color:red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" id="email" name="email" class="form-control" required>
                                        <p id="vemail" style="color:red;"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Message:</label>
                                        <textarea name="message" rows="8" id="message" class="form-control" required></textarea>
                                        <p id="vmessage" style="color:red;"></p>
                                    </div>
                                    <div id="load" style="display: none;" class="text-center"><img src="assets/images/loader.gif" style="width: 50px;padding-bottom: 5px; "></div>
                                    <div class="form-group" id="submt">
                                        <label class="col-md-4 control-label"></label>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-ocean btn-block">Send</button>
                                        </div>
                                    </div>

                                </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews">
                                <h3>Write a Review</h3>
                                <hr>
                                <div class="row" style="margin-bottom: 20px">
                                    <div class="col-md-6">
                                        <div class='starrr' id='star1'></div>
                                        <div>
                                        <span class='your-choice-was' style='display: none;'>
                                            Your rating is: <span class='choice'></span>.
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{route('review.submit')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="rating" id="rate" value="5">
                                    <input type="hidden" name="userid" value="{{$profiledata->id}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input name="name" placeholder="Full Name" class="form-control" type="text" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input name="email" placeholder="Your Email" class="form-control" type="email" required>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Text input-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <textarea name="review" rows="6" placeholder="Review Description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="resp" class="col-md-6">
                                        @if ($errors->has('error'))
                                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                        @endif
                                    </div>
                                    <!-- Button -->
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-4 col-md-offset-1">
                                                <button type="submit" class="btn btn-ocean btn-block" id="LoginButton"><strong>Submit Review</strong></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <h3>Reviews:</h3>
                                <hr>
                                @forelse($reviews as $review)
                                    <div class="row rating-row">
                                        <div class="col-md-3">
                                            <strong>{{$review->name}}</strong>
                                            <div class="rating-box">
                                                @for($i=1;$i<=5;$i++)
                                                    @if($i <= $review->rating)
                                                        <div class="star"><i class="fa fa-star"></i></div>
                                                    @else
                                                        <div class="star"><i class="fa fa-star-o"></i></div>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="rating-date">{{$review->review_date}}</div>
                                        </div>
                                        <div class="col-md-8">
                                            {{$review->review}}
                                        </div>
                                    </div>
                                @empty
                                    <h4>No review has given yet.</h4>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
               
            </div>
            <div class="col-md-4 contact-info">
                @if($profiledata->photo != "")
                    <img src="{{url('/')}}/assets/images/profile_photo/{{$profiledata->photo}}" alt="" style="max-width: 100%;" class="profile-image">
                @else
                    <img src="{{url('/')}}/assets/images/profile_photo/avatar.jpg" class="profile-image" alt="{{$profiledata->name}}">
                @endif
                <div>
                <h3>Contact Info</h3><hr>
                <div class="profile-group">
                     <p class="profile-contact"><i class="fa fa-home fa-1x"></i> {{$profiledata->address}}</p>
                     <p class="profile-contact"><i class="fa fa-building fa-1x"></i> {{$profiledata->city}}</p>
					@if($profiledata->fax != null))
						 <p class="profile-contact"><i class="fa fa-fax fa-1x"></i> {{$profiledata->fax}}</p>
					@endif
					@if($profiledata->phone != null))
						 <p class="profile-contact"><i class="fa fa-phone fa-1x"></i> {{$profiledata->phone}}</p>
					 @endif
                     <p class="profile-contact"><i class="fa fa-envelope fa-1x"></i> {{$profiledata->email}}</p>
					 @if($profiledata->website != null))
						 <p class="profile-contact"><i class="fa fa-globe fa-1x"></i> {{$profiledata->website}}</p>
					 @endif
                </div>
                     <h3>Share Profile</h3><hr>
                    <div class="profile-group">
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                        <a class="a2a_dd" href="https://www.geniusocean.com"></a>
                        <a class="a2a_button_facebook"></a>
                        <a class="a2a_button_twitter"></a>
                        <a class="a2a_button_google_plus"></a>
                        <a class="a2a_button_linkedin"></a>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </div>
                <div class="text-center">
                    <div class="desktop-advert">
                        @if(!empty($ads300x250))
                            @if($ads300x250->type == "banner")
                                <a class="ads" href="{{$ads300x250->redirect_url}}" target="_blank">
                                    <img class="banner-300x250" src="{{url('/')}}/assets/images/ads/{{$ads300x250->banner_file}}" alt="Advertisement">
                                </a>
                            @else
                                {!! $ads300x250->script !!}
                            @endif
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')
    <script>
        $('#star1').starrr({
            rating: 5,
            change: function(e, value){
                if (value) {
                    $('.your-choice-was').show();
                    $('.choice').text(value);
                    $('#rate').val(value);
                } else {
                    $('.your-choice-was').hide();
                }
            }
        });
    </script>
@stop