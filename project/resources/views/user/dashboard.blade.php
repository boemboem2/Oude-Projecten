@extends('user.includes.master-user')

@section('content')

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">
                <div class="container">
                    <div class="col-md-12 text-center">
                        <h1>My Profile</h1>(<a href="{{route('user.profile.edit')}}">Edit</a>)<hr>
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <h3>Name: <strong>{{$user->name}}</strong></h3>
                        <p>Category: <strong>{{$user->category}}</strong></p>
                        <div class="profile-section">
                            <h3 class="no-margin">Profile Description</h3><hr>
                            {!! $user->description !!}
                        </div>
                        <div class="profile-section">
                            <h3 class="no-margin">Specialties</h3><hr>
                            <ul class="col-md-12 specialities">
                                @foreach($user->specialities as $speciality)
                                    <li class="col-md-6 specialitie">{{$speciality}}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="profile-section">
                            <h3 class="no-margin">Qualifications</h3><hr>
                            <ul class="col-md-12 qualifications">
                                <li class="col-md-12 qualification">
                                    <strong>Gender</strong>
                                    <span>{{$user->gender}}</span>
                                </li>
								@if(!empty($user->qtitles))
									@foreach(array_combine($user->qtitles, $user->qualifications) as $title => $quality)
										<li class="col-md-12 qualification">
											<strong>{{$title}}</strong>
											<span>{{$quality}}</span>
										</li>
									@endforeach
								@endif
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-4 contact-info">
                        <div class="row">
                            @if($user->status != 1)
                                <div class="col-md-12" style="margin-bottom:10px;">
                                    {{--<a href="{{route('user.publish',['id' => $user->id])}}">--}}
                                    <a href="javascript:">
                                        <button type="button" data-toggle="modal" data-target="#ModalAll" class="btn btn-info pull-right">Publish My Profile</button>
                                    </a>
                                </div>
                            @elseif($user->featured != 1)
                                <div class="col-md-12" style="margin-bottom:10px;">
                                    {{--<a href="{{route('user.publish',['id' => $user->id])}}">--}}
                                    <a href="javascript:">
                                        <button type="button" data-toggle="modal" data-target="#ModalFeature" class="btn btn-info pull-right">Feature My Profile</button>
                                    </a>
                                </div>
                            @endif
                        </div>
                        @if($user->photo != "")
                            <img src="{{url('/')}}/assets/images/profile_photo/{{$user->photo}}" alt="" style="max-width: 100%;" class="profile-image">
                        @else
                            <img src="{{url('/')}}/assets/images/profile_photo/avatar.jpg" class="profile-image" alt="{{$user->name}}">
                        @endif
                        <div>
                            <h3>Contact Info</h3><hr>
                            <div class="profile-group">
                                <p class="profile-contact"><i class="fa fa-home fa-1x"></i>  {{$user->address}}</p>
                                <p class="profile-contact"><i class="fa fa-fax fa-1x"></i> {{$user->fax}}</p>
                                <p class="profile-contact"><i class="fa fa-phone fa-1x"></i> {{$user->phone}}</p>
                                <p class="profile-contact"><i class="fa fa-envelope fa-1x"></i> {{$user->email}}</p>
                                <p class="profile-contact"><i class="fa fa-globe fa-1x"></i> {{$user->website}}</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->



    <style>
        .fade-scale {
            transform: scale(0);
            opacity: 0;
            -webkit-transition: all .25s linear;
            -o-transition: all .25s linear;
            transition: all .25s linear;
        }

        .fade-scale.in {
            opacity: 1;
            transform: scale(1);
        }
        .modal-dialog{
            margin:150px auto;
        }
        .cost{
            color:#0099FF;
        }
    </style>


    <!-- Modal -->
    <div class="modal fade-scale" id="ModalAll" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Publish Your Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 id="cost" class="cost"></h4>
                            <h4>Select Premium Features</h4>
                            <form class="paypal" action="{{route('payment.submit')}}" method="post" id="payment_form">
                                {{csrf_field()}}
                                <input type="hidden" name="cmd" value="_xclick" />
                                <input type="hidden" name="no_note" value="1" />
                                <input type="hidden" name="lc" value="UK" />
                                <input type="hidden" name="currency_code" value="USD" />
                                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                <div class="form-group col-md-8 col-md-offset-2">
                                    <select name="featured" class="form-control" id="opt" required>
                                        <option value="">Select Option</option>
                                        <option value="no">Normal Profile</option>
                                        <option value="yes">Featured Profile</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8 col-md-offset-2">
                                    <select class="form-control" onChange="meThods(this)" id="formac" name="method" required>
                                        <option value="Paypal" selected>Paypal</option>
                                        <option value="Stripe">Credit Card</option>
                                    </select>
                                </div>
                                <input type="hidden" name="userid" value="{{$user->id}}" />

                                <div id="stripes" class="col-md-8 col-md-offset-2" style="display: none;">
                                    <img class="pull-right" src="{{url('/assets/images')}}/creditcards.png">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="card" placeholder="Card">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cvv" placeholder="Cvv">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="month" placeholder="Month">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="year" placeholder="Year">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="submit" name="submit" id="pay" class="btn btn-success" value="Pay Now"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade-scale" id="ModalFeature" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Feature Your Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>Make Your Profile Featured</h4>
                            <h4 class="cost">Total Cost: 10$</h4>
                            <form class="paypal" action="{{route('payment.submit')}}" method="post" id="payment_form2">
                                {{csrf_field()}}

                                <div class="form-group col-md-8 col-md-offset-2">
                                    <select class="form-control" onChange="meThods2(this)" id="formac" name="method" required>
                                        <option value="Paypal" selected>Paypal</option>
                                        <option value="Stripe">Credit Card</option>
                                    </select>
                                </div>
                                <input type="hidden" name="cmd" value="_xclick" />
                                <input type="hidden" name="no_note" value="1" />
                                <input type="hidden" name="lc" value="UK" />
                                <input type="hidden" name="currency_code" value="USD" />
                                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                <input type="hidden" name="featured" value="yes" />
                                <input type="hidden" name="userid" value="{{$user->id}}" />

                                <div id="stripes2" class="col-md-8 col-md-offset-2" style="display: none;">
                                    <img class="pull-right" src="{{url('/assets/images')}}/creditcards.png">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="card" placeholder="Card">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cvv" placeholder="Cvv">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="month" placeholder="Month">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="year" placeholder="Year">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="submit" name="submit" id="pay2" class="btn btn-success" value="Pay Now"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>




@stop

@section('footer')
<script>
    $("#opt").change(function(){

        var opt = $("#opt").val();

        if(opt=="yes"){
            $("#cost").html("Total Cost: 20$");
        }else{
            $("#cost").html("Total Cost: 10$");
        }

    });
//    $('#pay').click(function(e) {
//
//        var opt = $("#opt").val();
//        if(opt !=""){
//
//            $('#ModalAll').modal('toggle'); //or  $('#IDModal').modal('hide');
//        }
//    });
//    $('#pay2').click(function(e) {
//        $('#ModalFeature').modal('toggle'); //or  $('#IDModal').modal('hide');
//    });

    function meThods(val) {
        var action1 = "{{route('payment.submit')}}";
        var action2 = "{{route('stripe.submit')}}";
        if (val.value == "Paypal") {
            $("#payment_form").attr("action", action1);
            $("#stripes").hide();
            $("#stripes").find("input").attr('required',false);
        }
        if (val.value == "Stripe") {
            $("#payment_form").attr("action", action2);
            $("#stripes").show();
            $("#stripes").find("input").attr('required',true);
        }
    }
    function meThods2(val) {
        var action1 = "{{route('payment.submit')}}";
        var action2 = "{{route('stripe.submit')}}";
        if (val.value == "Paypal") {
            $("#payment_form2").attr("action", action1);
            $("#stripes2").hide();
            $("#stripes2").find("input").attr('required',false);
        }
        if (val.value == "Stripe") {
            $("#payment_form2").attr("action", action2);
            $("#stripes2").show();
            $("#stripes2").find("input").attr('required',true);
        }
    }
</script>
@stop