@extends('user.includes.master-user')

@section('content')

    <div id="page-wrapper">
    <div class="container-fluid">
        <div class="row" id="main">

            <!-- Page Heading -->
            <div class="go-title">
                <div class="pull-right">
                    <a href="{!! route('user.dashboard') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <h3>Edit My Profile</h3>
                <div class="go-line"></div>
            </div>
            <!-- Page Content -->
            <div class="panel panel-default">
                <div class="panel-body">

                    <div id="response">
                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>
                    <form method="POST" action="{{ action('UserProfileController@update', ['id' => $user->id]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">

                        {{csrf_field()}}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Full Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->name}}" name="name" placeholder="Lawyers Name" required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Category<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="category" class="form-control" required>
                                    <option value="">Select Handymen Category</option>
                                    @foreach($categories as $category)
                                        @if($category->name == $user->category)
                                            <option value="{{$category->name}}" selected>{{$category->name}}</option>
                                        @else
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Current Photo<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <img src="{!! url('assets/images/profile_photo') !!}/{{$user->photo}}" style="max-width: 200px;" alt="No Photo Added" id="docphoto">

                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Profile Photo <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" accept="image/*" name="photo" class="hidden" onchange="readURL(this)" id="uploadFile"/>
                                <div id="uploadTrigger" class="form-control btn btn-default"><i class="fa fa-upload"></i> Add Profile Photo</div><br><br>
                                <p class="small-label">Prefered Size: (600x600) or Square Sized Image</p>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Profile Description<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="profiledesc" name="description">{!! $user->description !!}</textarea>
                            </div>
                        </div>
                        <div class="form-line"></div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Interests <span class="required">*</span>
                                <p class="small-label">Separated by Comma(,)</p>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="specialities" value="{{$user->specialities}}" placeholder="Practice Areas" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Gender<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="gender" required>
                                    <option value="">Select Gender</option>
                                    @if($user->gender == "Male")
                                        <option value="Male" selected>Male</option>
                                    @else
                                        <option value="Male">Male</option>
                                    @endif
                                    @if($user->gender == "Female")
                                        <option value="Female" selected>Female</option>
                                    @else
                                        <option value="Female">Female</option>
                                    @endif
                                    @if($user->gender == "Other")
                                        <option value="Other" selected>Male</option>
                                    @else
                                        <option value="Other">Other</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <h4 class="col-md-offset-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 0">Qualifications</h4>
                        </div>
                        <div class="form-line"></div>
                        <div class="col-md-offset-3 col-md-8" style="padding-left: 5px;" id="qualiTies">
						@if(!empty($user->qtitles))
                            @foreach(array_combine($user->qtitles, $user->qualifications) as $title => $quality)
                                <div class="item form-group qfield">
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control col-md-12 col-xs-12" name="q_titles[]" value="{{$title}}" placeholder="Title" required="required" type="text">
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control col-md-12 col-xs-12" name="qualities[]" value="{{$quality}}" placeholder="Text / Details" required="required" type="text">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <span class="removeField"><i class="fa fa-times-circle fa-2x"></i></span>
                                    </div>
                                </div>
                            @endforeach
						@else
							<div class="item form-group qfield">
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control col-md-12 col-xs-12" name="q_titles[]" placeholder="Title" required="required" type="text">
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input class="form-control col-md-12 col-xs-12" name="qualities[]" placeholder="Text / Details" required="required" type="text">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <span class="removeField"><i class="fa fa-times-circle fa-2x"></i></span>
                                    </div>
                                </div>
						@endif
                        </div>
                        <div class="item form-group">
                            <div class="col-md-offset-3 col-md-8">
                                <button class="btn btn-default" type="button" id="addField"><i class="fa fa-plus fa-fw"></i>Add More Field</button>
                            </div>
                        </div>

                        <div class="form-line"></div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">City<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->city}}" name="city" placeholder="City" required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Address<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->address}}" name="address" placeholder="Address" required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Phone<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->phone}}" name="phone" placeholder="Phone" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Fax<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->fax}}" name="fax" placeholder="Fax" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Email<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->email}}" name="email" placeholder="Email" required="required" type="text" disabled>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Website<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" value="{{$user->website}}" name="website" placeholder="Website" type="text">
                            </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="add_ads" type="submit" class="btn btn-success btn-block">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@stop
@section('footer')
<script>

    $("#uploadTrigger").click(function(){
        $("#uploadFile").click();
        $("#uploadFile").change(function(event) {
            $("#uploadTrigger").html($("#uploadFile").val());
        });
    });
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#docphoto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    bkLib.onDomLoaded(function() {
        new nicEditor().panelInstance('profiledesc');
    });

    $('#addField').click(function(){
        $('#qualiTies').append('<div class="item form-group qfield"><div class="col-md-5 col-sm-5 col-xs-5"><input class="form-control col-md-12 col-xs-12" name="q_titles[]" placeholder="Title" required="required" type="text"></div><div class="col-md-5 col-sm-5 col-xs-12"><input class="form-control col-md-12 col-xs-12" name="qualities[]" placeholder="Text / Details" required="required" type="text"></div><div class="col-md-2 col-sm-2 col-xs-12"><span class="removeField"><i class="fa fa-times-circle fa-2x"></i></span></div></div>');
        $('.removeField').click(function(){
            $(this).parent().parent().remove();
        });
    });

    $('.removeField').click(function(){
        $(this).parent().parent().remove();
    });
</script>
@stop