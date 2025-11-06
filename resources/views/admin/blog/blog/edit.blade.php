@extends('admin.layout')

@if(!empty($blog->language) && $blog->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Edit Blog</h4>
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
                <a href="#">Blog Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Blog</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Blog</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                       href="{{route('admin.blog.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <form id="ajaxForm" class="" action="{{route('admin.blog.update')}}" method="post">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{$blog->id}}">

                                {{-- Image Part --}}
                                <div class="form-group">
                                    <label for="">Image ** </label>
                                    <br>
                                    <div class="thumb-preview" id="thumbPreview1">
                                        <img src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                             alt="User Image">
                                    </div>
                                    <br>
                                    <br>


                                    <input id="fileInput1" type="hidden" name="image">
                                    <button id="chooseImage1" class="choose-image btn btn-primary" type="button"
                                            data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose
                                        Image
                                    </button>


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

                                {{-- Alt Image --}}
                                <div class="form-group">
                                    <label for="">Alt Image</label>
                                    <input type="text" class="form-control" name="alt_image" value="{{ $blog->alt_image }}" placeholder="Enter alt text for image">
                                    <p id="erralt_image" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Title **</label>
                                    <input type="text" class="form-control" name="title" value="{{$blog->title}}"
                                           placeholder="Enter title" id="titleInput">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Slug **</label>
                                    <input type="text" class="form-control" name="slug" value="{{$blog->slug}}"
                                           placeholder="Enter slug" id="slugInput">
                                    <p id="errslug" class="mb-0 text-danger em"></p>
                                    <p class="text-warning"><small>Leave empty to auto-generate from title. Use lowercase letters, numbers, and hyphens only.</small></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Category **</label>
                                    <select class="form-control" name="category">
                                        <option value="" selected disabled>Select a category</option>
                                        @foreach ($bcats as $key => $bcat)
                                            <option
                                                value="{{$bcat->id}}" {{$bcat->id == $blog->bcategory->id ? 'selected' : ''}}>{{$bcat->name}}</option>
                                        @endforeach
                                    </select>
                                    <p id="errcategory" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Content **</label>
                                    <textarea id="blogContent" class="form-control summernote" name="content"
                                              data-height="300"
                                              placeholder="Enter content">{{replaceBaseUrl($blog->content)}}</textarea>
                                    <p id="errcontent" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Serial Number **</label>
                                    <input type="number" class="form-control ltr" name="serial_number"
                                           value="{{$blog->serial_number}}" placeholder="Enter Serial Number">
                                    <p id="errserial_number" class="mb-0 text-danger em"></p>
                                    <p class="text-warning"><small>The higher the serial number is, the later the blog
                                            will be shown.</small></p>
                                </div>

                                {{-- Tags --}}
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <select id="tags" class="form-control select2" name="tags[]" multiple>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ $blog->tags ? in_array($tag->id, $blog->tags->pluck('id')->toArray()) ? 'selected' : ''  : ''}}>
                                                {{ $tag->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p id="errtags" class="mb-0 text-danger em"></p>
                                </div>

                                {{-- Meta Title --}}
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" maxlength="255" placeholder="Enter meta title" value="{{ $blog->meta_title }}">
                                    <p id="errmeta_title" class="text-danger mb-0 em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Meta Keywords</label>
                                    <input type="text" class="form-control" name="meta_keywords"
                                           value="{{$blog->meta_keywords}}" data-role="tagsinput">
                                    <p id="errmeta_keywords" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Meta Description</label>
                                    <textarea type="text" class="form-control" name="meta_description"
                                              rows="5">{{$blog->meta_description}}</textarea>
                                    <p id="errmeta_description" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Redirect URL</label>
                                    <input type="url" class="form-control" name="redirect_url" value="{{ $blog->redirect_url }}" placeholder="https://example.com/redirect">
                                    <p id="errredirect_url" class="text-danger mb-0 em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Index Page?</label>
                                    <select name="is_indexed" class="form-control">
                                        <option value="" disabled {{ is_null($blog->is_indexed) ? 'selected' : '' }}>Select indexing option</option>
                                        <option value="1" {{ $blog->is_indexed === 1 ? 'selected' : '' }}>Yes - index & follow</option>
                                        <option value="0" {{ $blog->is_indexed === 0 ? 'selected' : '' }}>No - noindex</option>
                                    </select>
                                    <p id="erris_indexed" class="text-danger mb-0 em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Publish Date</label>
                                    <input type="datetime-local" name="publish_data" class="form-control"
                                           value="{{ $blog->publish_data ? \Carbon\Carbon::parse($blog->publish_data)->format('Y-m-d\TH:i') : '' }}">
                                    <p id="errpublish_data" class="text-danger mb-0 em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Canonical URL</label>
                                    <input type="url" name="canonical" class="form-control" value="{{ $blog->canonical }}" placeholder="https://example.com/original-post">
                                    <p id="errcanonical" class="text-danger mb-0 em"></p>
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
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let slugManuallyEdited = false;
    
    // Function to generate slug from title
    function generateSlug(title) {
        return title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
            .trim('-'); // Remove leading/trailing hyphens
    }
    
    // Auto-generate slug when title changes (only if slug hasn't been manually edited)
    $('#titleInput').on('input', function() {
        if (!slugManuallyEdited) {
            const title = $(this).val();
            const slug = generateSlug(title);
            $('#slugInput').val(slug);
        }
    });
    
    // Track when slug is manually edited
    $('#slugInput').on('input', function() {
        slugManuallyEdited = true;
    });
    
    // Reset manual edit flag when slug is cleared
    $('#slugInput').on('blur', function() {
        if ($(this).val() === '') {
            slugManuallyEdited = false;
        }
    });
});
</script>
@endsection
