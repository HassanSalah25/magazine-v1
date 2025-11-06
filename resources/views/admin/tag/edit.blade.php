@extends('admin.layout')

@if(!empty($tag->language) && $tag->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            .nicEdit-main {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Edit Tag</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('admin.dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tag Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Tag</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Tag</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                       href="{{route('admin.tag.index') . '?language=' . request()->input('language')}}">
          <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
          </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">


                            <form id="ajaxForm" class="" action="{{route('admin.tag.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="tag_id" value="{{$tag->id}}">

                                {{-- Image Part --}}
                                <div class="form-group">
                                    <label for="">Image ** </label>
                                    <br>
                                    <div class="thumb-preview" id="thumbPreview1">
                                        <img src="{{asset('assets/front/img/tags/featured/'.$tag->image)}}"
                                             alt="User Image">
                                    </div>
                                    <br>
                                    <br>


                                    <input id="fileInput1" type="hidden" name="image">
                                    <button id="chooseImage1" class="choose-image btn btn-primary" type="button" data-multiple="false"
                                            data-toggle="modal" data-target="#lfmModal1">Choose Image</button>


                                    <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                                    <p class="em text-danger mb-0" id="errimage"></p>

                                    <!-- Image LFM Modal -->
                                    <div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog"
                                         aria-labelledby="lfmModalTitle" aria-hidden="true">
                                        <i class="fas fa-times-circle"></i>
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <iframe src="{{url('laravel-filemanager')}}?serial=1"
                                                            style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Title **</label>
                                            <input type="text" class="form-control" name="title" value="{{$tag->title}}"
                                                   placeholder="Enter title">
                                            <p id="errtitle" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Slug **</label>
                                            <input type="text" class="form-control" name="slug" value="{{$tag->slug}}"
                                                   placeholder="Enter slug">
                                            <p id="errslug" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Status **</label>
                                            <select class="form-control ltr" name="status">
                                                <option value="" selected disabled>Select a status</option>
                                                <option value="0" {{$tag->status == 0 ? 'selected' : ''}}>Active
                                                </option>
                                                <option value="1" {{$tag->status == 1 ? 'selected' : ''}}>In Active</option>
                                            </select>
                                            <p id="errstatus" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Serial Number **</label>
                                            <input type="number" class="form-control ltr" name="serial_number"
                                                   value="{{$tag->serial_number}}" placeholder="Enter Serial Number">
                                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                                            <p class="text-warning mb-0"><small>The higher the serial number is, the later the tag will be
                                                    shown.</small></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Content **</label>
                                            <textarea id="portContent" class="form-control summernote" name="content" rows="8"
                                                      placeholder="Enter content" data-height="300">{{replaceBaseUrl($tag->content)}}</textarea>
                                            <p id="errcontent" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input class="form-control" name="meta_title" value="{{$tag->meta_title}}"
                                           placeholder="Enter meta title">
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input class="form-control" name="meta_keywords" value="{{$tag->meta_keywords}}"
                                           placeholder="Enter meta keywords" data-role="tagsinput">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="meta_description" rows="5"
                                              placeholder="Enter meta description">{{$tag->meta_description}}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="form-group">
                                            <label>Canonical</label>
                                            <input class="form-control" name="canonical" value="{{ $tag->canonical }}"
                                                   placeholder="Enter canonical">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection


        @section('scripts')
            {{-- dropzone --}}
            <script>
                // myDropzone is the configuration for the element that has an id attribute
                // with the value my-dropzone (or myDropzone)
                Dropzone.options.myDropzone = {
                    acceptedFiles: '.png, .jpg, .jpeg',
                    url: "{{route('admin.tag.sliderstore')}}",
                    success : function(file, response){
                        console.log(response.file_id);

                        // Create the remove button
                        var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");


                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            _this.removeFile(file);

                            rmvimg(response.file_id);
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);

                        var content = {};

                        content.message = 'Slider images added successfully!';
                        content.title = 'Success';
                        content.icon = 'fa fa-bell';

                        $.notify(content,{
                            type: 'success',
                            placement: {
                                from: 'top',
                                align: 'right'
                            },
                            time: 1000,
                            delay: 0,
                        });
                    }
                };

                function rmvimg(fileid) {
                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.

                    $.ajax({
                        url: "{{route('admin.tag.sliderrmv')}}",
                        type: 'POST',
                        data: {
                            _token: "{{csrf_token()}}",
                            fileid: fileid
                        },
                        success: function(data) {
                            var content = {};

                            content.message = 'Slider image deleted successfully!';
                            content.title = 'Success';
                            content.icon = 'fa fa-bell';

                            $.notify(content,{
                                type: 'success',
                                placement: {
                                    from: 'top',
                                    align: 'right'
                                },
                                time: 1000,
                                delay: 0,
                            });
                        }
                    });

                }
            </script>


            <script>
                var el = 0;

                $(document).ready(function(){
                    $.get("{{route('admin.tag.images', $tag->id)}}", function(data){
                        for (var i = 0; i < data.length; i++) {
                            $("#imgtable").append('<tr class="trdb" id="trdb'+data[i].id+'"><td><div class="thumbnail"><img style="width:150px;" src="{{asset('assets/front/img/tags/sliders/')}}/'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+data[i].id+')"><i class="fa fa-times"></i></button></td></tr>');
                        }
                    });
                });

                function rmvdbimg(indb) {
                    $(".request-loader").addClass("show");
                    $.ajax({
                        url: "{{route('admin.tag.sliderrmv')}}",
                        type: 'POST',
                        data: {
                            _token: "{{csrf_token()}}",
                            fileid: indb
                        },
                        success: function(data) {
                            $(".request-loader").removeClass("show");
                            $("#trdb"+indb).remove();
                            var content = {};

                            content.message = 'Slider image deleted successfully!';
                            content.title = 'Success';
                            content.icon = 'fa fa-bell';

                            $.notify(content,{
                                type: 'success',
                                placement: {
                                    from: 'top',
                                    align: 'right'
                                },
                                time: 1000,
                                delay: 0,
                            });
                        }
                    });
                }

                var today = new Date();
                $("#submissionDate").datepicker({
                    autoclose: true,
                    endDate : today,
                    todayHighlight: true
                });
                $("#startDate").datepicker({
                    autoclose: true,
                    endDate : today,
                    todayHighlight: true
                });
            </script>
@endsection
