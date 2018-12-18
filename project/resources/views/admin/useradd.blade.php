@extends('admin.includes.master-admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('admin/users') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <h3>Add New Photographer</h3>
                    <div class="go-line"></div>
                </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="response"></div>
                        <form method="POST" action="{!! action('UsersController@store') !!}" id="add_form" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Full Name<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="name" placeholder="Photographer Name" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Category<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="category" class="form-control">
                                        <option>Select Photographer Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Current Photo<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <img src="" style="max-width: 200px;" alt="No Photo Added" id="docphoto">

                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Profile Photo <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" accept="image/*" name="photo" class="hidden" onchange="readURL(this)" id="uploadFile"/>
                                    <div id="uploadTrigger" class="form-control btn btn-default"><i class="fa fa-upload"></i> Add Lawyer Photo</div><br><br>
                                    <p class="small-label">Prefered Size: (600x600) or Square Sized Image</p>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"> Gallery Photos <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" accept="image/*" name="gallery[]" multiple/>
                                    <br>
                                    <p class="small-label">Multiple Image Allowed</p>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Profile Description<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <textarea id="profiledesc" name="description">

                                  </textarea>
                                </div>
                            </div>
                            <div class="form-line"></div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Interests <span class="required">*</span>
                                    <p class="small-label">Separated by Comma(,)</p>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="specialities" placeholder="Practice Areas" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Gender<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="gender">
                                        <option>Select Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="item form-group">
                                <h4 class="col-md-offset-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 0">Qualifications</h4>
                            </div>
                            <div class="form-line"></div>
                            <div class="col-md-offset-3 col-md-8" style="padding-left: 5px;" id="qualiTies">

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
                                    <input class="form-control col-md-7 col-xs-12" name="city" placeholder="City" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Address<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="address" placeholder="Address" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Phone<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="phone" placeholder="Phone" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Fax<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="fax" placeholder="Fax" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Email<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="email" placeholder="Email" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Website<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12" name="website" placeholder="Website" required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">
                                </label>
                                <div class="col-md-9 col-sm-6 col-xs-12" data-toggle="buttons">
                                    <label class="btn btn-default">
                                        <input type="checkbox" name="featured" value="1" autocomplete="off">
                                        <span class="go_checkbox"><i class="glyphicon glyphicon-ok"></i></span>
                                        Add to Featured Photographer
                                    </label>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="add_ads" type="submit" class="btn btn-success btn-block">Add Photographer</button>
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