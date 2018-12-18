<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="keywords" content="{{$code[0]->meta_keys}}">
    <meta name="author" content="GeniusOcean">
    <link rel="icon" type="image/png" href="{{url('/')}}/assets/images/{{$settings[0]->favicon}}" />
    <title>{{$settings[0]->title}}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/css/genius1.css')}}" rel="stylesheet">

    <link rel='stylesheet' href='{{ URL::asset('assets/css/unite-gallery.css')}}' type='text/css' />
    <link rel='stylesheet' href='{{ URL::asset('assets/css/ug-theme-default.css')}}' type='text/css' />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="cover"></div>
<div class="theme2">
    <div class="row">
        <div class="pull-left gologo">
            <a href="{{ url('/') }}"><img class="img-responsive" src="{{ URL::asset('assets/images/logo')}}/{{$settings[0]->logo}}" alt="Lawyer Directory"></a>
        </div>

        <div class="pull-right headad">
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

    </div>

    <nav class="navbar navbar-bootsnipp " role="navigation" id="nav_bar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="animbrand">
                    <div class="navbar-brand" href=""></div>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/') }}" class="">Home</a></li>
                    <li><a href="{{url('/listfeatured')}}" class="">Featured Photographers</a></li>
                    <li><a href="{{url('/listall')}}" class="">All Photographers</a></li>

                    @if($pagesettings[0]->a_status == 1)
                        <li><a href="{{url('/about')}}" class="">About Us</a></li>
                    @endif
                    @if($pagesettings[0]->f_status == 1)
                        <li><a href="{{url('/faq')}}" class="">FAQ</a></li>
                    @endif
                    @if($pagesettings[0]->c_status == 1)
                        <li><a href="{{url('/contact')}}" class="">Contact Us</a></li>
                    @endif
                    @if(Auth::guard('profile')->guest())
                        <li><a href="{{url('/user/login')}}" class="">Login</a></li>
                        <li><a href="{{url('/user/registration')}}" class="">Registration</a></li>
                    @else
                        <li><a href="{{url('/user/dashboard')}}" class="">My Account</a></li>
                    @endif


                </ul>
            </div>
        </div>
    </nav>


    @yield('content')

<footer>

<div class="go-top">
    <a id="gtop" href="javascript:;"><i class="fa fa-angle-up"></i></a>
</div>
<div class="row">
    <div class="col-md-3 about">
        <h4>About Us</h4>
        <p>{{$settings[0]->about}}</p>
    </div>
    <div class="col-md-3 address">
        <h4>Address</h4>
        <p>Street Address: {{$settings[0]->address}}</p>
		@if($settings[0]->phone != null)
			<p>Phone: {{$settings[0]->phone}}</p>
		@endif
		@if($settings[0]->fax != null)
			<p>Fax:  {{$settings[0]->fax}}</p>
		@endif
        <p>Email: {{$settings[0]->email}}</p>
    </div>
    <div class="col-md-3">
                    <div class="socicon text-center">
                        @if($sociallinks[0]->f_status == "enable")
                            <a href="{{$sociallinks[0]->facebook}}" class="facebook"><i class="fa fa-facebook"></i></a>
                        @endif
                        @if($sociallinks[0]->t_status == "enable")
                            <a href="{{$sociallinks[0]->twiter}}" class="twitter"><i class="fa fa-twitter"></i></a>
                        @endif
                        @if($sociallinks[0]->g_status == "enable")
                            <a href="{{$sociallinks[0]->g_plus}}" class="google"><i class="fa fa-google"></i></a>
                        @endif
                        @if($sociallinks[0]->link_status == "enable")
                            <a href="{{$sociallinks[0]->linkedin}}" class="linkedin"><i class="fa fa-linkedin"></i></a>
                        @endif
                    </div>
    </div>      
    <div class="col-md-3 text-center">
        <form action="{{action('FrontEndController@subscribe')}}" method="post">
            {{csrf_field()}}
            <h4>Subscription:</h4>
            <input type="text" id="email" class="form-control" name="email" required>
            <p id="resp">
            @if(Session::has('subscribe'))
                    {{ Session::get('subscribe') }}
            @endif
            </p>
            <button id="subs" class="btn btn-ocean">Subscribe</button>
        </form>
    </div>
</div>
      

<div class="c-line"></div>


            <div class="text-center">
                {!! $settings[0]->footer !!}
            </div>

</footer>
</div>
    <!-- jQuery -->
    <script src="{{ URL::asset('assets/js/jquery.js')}}"></script>
    <script src="{{ URL::asset('assets/js/jquery.smooth-scroll.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/genius.js')}}"></script>
    <script type='text/javascript' src='{{ URL::asset('assets/js/unitegallery.min.js')}}'></script>
    <script type='text/javascript' src='{{ URL::asset('assets/js/ug-theme-compact.js')}}'></script>
    <script type="text/javascript">
        $(window).load(function(){
            setTimeout(function(){
                $('#cover').fadeOut(1000);
            },1000)
        });
        jQuery(document).ready(function(){
            jQuery("#gallery").unitegallery({
                gallery_autoplay:true,
                slider_controls_always_on: false
            });
        });
    </script>

    {!! $code[0]->google_analytics !!}

    @yield('footer')

</body>
</html>