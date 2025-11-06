@extends('admin.layout')

@php
    $selLang = \App\Models\Language::where('code', request()->input('language'))->first();
@endphp

@if(!empty($selLang) && $selLang->rtl == 1)
    @section('styles')
        <style>
            form:not(.modal-form) input,
            form:not(.modal-form) textarea,
            form:not(.modal-form) select,
            select[name='language'] {
                direction: rtl;
            }

            form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Blogs</h4>
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
                <a href="#">Blogs</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Blogs</div>
                        </div>
                        <div class="col-lg-3">
                            @if (!empty($langs))
                                <select name="language" class="form-control"
                                        onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($langs as $lang)
                                        <option
                                            value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                            <a href="{{ route('admin.blog.carousel.management') }}?language={{ request()->input('language') }}" class="btn btn-info float-right btn-sm mr-2">
                                <i class="fas fa-sliders-h"></i> Carousel Management
                            </a>
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                               data-target="#createModal"><i class="fas fa-plus"></i> Add Blog</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                    data-href="{{route('admin.blog.bulk.delete')}}"><i class="flaticon-interface-5"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($blogs) == 0)
                                <h3 class="text-center">NO BLOG FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Publish Date</th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Sidebar</th>
                                            <th scope="col">Carousel</th>
                                            <th scope="col">Featured Slider</th>
                                            <th scope="col">Hot Now</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($blogs as $key => $blog)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check" data-val="{{$blog->id}}">
                                                </td>
                                                <td><img src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                                         alt="" width="80"></td>
                                                <td>{{convertUtf8($blog->bcategory->name)}}</td>
                                                <td>{{convertUtf8(strlen($blog->title)) > 30 ? convertUtf8(substr($blog->title, 0, 30)) . '...' : convertUtf8($blog->title)}}</td>
                                                <td>
                                                    @php
                                                        $date = \Carbon\Carbon::parse($blog->created_at);
                                                    @endphp
                                                    {{$date->translatedFormat('jS F, Y')}}
                                                </td>
                                                <td>{{$blog->serial_number}}</td>
                                                <td>
                                                   <form id="statusForm{{$blog->id}}" class="d-inline-block" action="{{ route('admin.blog.sidebar') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                        {{-- hidden input عشان يبعت 0 لو الـ checkbox unchecked --}}
                                                        <input type="hidden" name="sidebar" value="0">

                                                        <label class="status-toggle">
                                                            <input type="checkbox"
                                                                name="sidebar"
                                                                value="1"
                                                                onchange="document.getElementById('statusForm{{$blog->id}}').submit();"
                                                                {{ $blog->sidebar == 1 ? 'checked' : '' }}>
                                                            <div class="status-toggle-track"></div>
                                                            <div class="status-toggle-knob">
                                                                <div class="status-toggle-face status-toggle-face--off"></div>
                                                                <div class="status-toggle-face status-toggle-face--on"></div>
                                                            </div>
                                                        </label>
                                                    </form>

                                                </td>
                                                <td>
                                                   <form id="carouselForm{{$blog->id}}" class="d-inline-block" action="{{ route('admin.blog.carousel') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                        {{-- hidden input عشان يبعت 0 لو الـ checkbox unchecked --}}
                                                        <input type="hidden" name="show_in_carousel" value="0">

                                                        <label class="status-toggle">
                                                            <input type="checkbox"
                                                                name="show_in_carousel"
                                                                value="1"
                                                                onchange="document.getElementById('carouselForm{{$blog->id}}').submit();"
                                                                {{ $blog->show_in_carousel == 1 ? 'checked' : '' }}>
                                                            <div class="status-toggle-track"></div>
                                                            <div class="status-toggle-knob">
                                                                <div class="status-toggle-face status-toggle-face--off"></div>
                                                                <div class="status-toggle-face status-toggle-face--on"></div>
                                                            </div>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td>
                                                   <form id="featuredSliderForm{{$blog->id}}" class="d-inline-block" action="{{ route('admin.blog.featured.slider') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                        <input type="hidden" name="show_in_featured_slider" value="0">

                                                        <label class="status-toggle">
                                                            <input type="checkbox"
                                                                name="show_in_featured_slider"
                                                                value="1"
                                                                onchange="document.getElementById('featuredSliderForm{{$blog->id}}').submit();"
                                                                {{ $blog->show_in_featured_slider == 1 ? 'checked' : '' }}>
                                                            <div class="status-toggle-track"></div>
                                                            <div class="status-toggle-knob">
                                                                <div class="status-toggle-face status-toggle-face--off"></div>
                                                                <div class="status-toggle-face status-toggle-face--on"></div>
                                                            </div>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td>
                                                   <form id="hotNowForm{{$blog->id}}" class="d-inline-block" action="{{ route('admin.blog.hot.now') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                        {{-- hidden input عشان يبعت 0 لو الـ checkbox unchecked --}}
                                                        <input type="hidden" name="show_in_hot_now" value="0">

                                                        <label class="status-toggle">
                                                            <input type="checkbox"
                                                                name="show_in_hot_now"
                                                                value="1"
                                                                onchange="document.getElementById('hotNowForm{{$blog->id}}').submit();"
                                                                {{ $blog->show_in_hot_now == 1 ? 'checked' : '' }}>
                                                            <div class="status-toggle-track"></div>
                                                            <div class="status-toggle-knob">
                                                                <div class="status-toggle-face status-toggle-face--off"></div>
                                                                <div class="status-toggle-face status-toggle-face--on"></div>
                                                            </div>
                                                        </label>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm"
                                                       href="{{route('admin.blog.edit', $blog->id) . '?language=' . request()->input('language')}}">
                                            <span class="btn-label">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                                        Edit
                                                    </a>
                                                    <a class="btn btn-info btn-sm"
                                                       href="{{route('admin.blog.faq.index', $blog->id)}}">
                                            <span class="btn-label">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                                        FAQ
                                                    </a>
                                                    <form class="deleteform d-inline-block"
                                                          action="{{route('admin.blog.delete')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                                        <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                <span class="btn-label">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- Create Blog Modal -->
    <div
        class="modal fade"
        id="createModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-centered modal-lg"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="exampleModalLongTitle"
                    >Add Blog</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="modal-form" action="{{ route('admin.blog.store') }}" method="POST">
                        @csrf

                        {{-- Image --}}
                        <div class="form-group">
                            <label>Image **</label>
                            <div class="thumb-preview" id="thumbPreview1">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="User Image">
                            </div>
                            <input id="fileInput1" type="hidden" name="image">
                            <button id="chooseImage1" class="choose-image btn btn-primary" type="button"
                                    data-toggle="modal" data-target="#lfmModal1" data-multiple="false">Choose Image</button>
                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <p class="em text-danger mb-0" id="errimage"></p>
                        </div>

                        {{-- Alt Image --}}
                        <div class="form-group">
                            <label>Alt Image</label>
                            <input type="text" class="form-control" name="alt_image" placeholder="Enter alt text for image">
                            <p id="erralt_image" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Language --}}
                        <div class="form-group">
                            <label>Language **</label>
                            <select id="language" name="language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Title --}}
                        <div class="form-group">
                            <label>Title **</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title" id="createTitleInput">
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Slug --}}
                        <div class="form-group">
                            <label>Slug **</label>
                            <input type="text" class="form-control" name="slug" placeholder="Enter slug" id="createSlugInput">
                            <p id="errslug" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>Leave empty to auto-generate from title. Use lowercase letters, numbers, and hyphens only.</small></p>
                        </div>

                        {{-- Category --}}
                        <div class="form-group">
                            <label>Category **</label>
                            <select id="bcategory" class="form-control" name="category" disabled>
                                <option value="" selected disabled>Select a category</option>
                            </select>
                            <p id="errcategory" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Content --}}
                        <div class="form-group">
                            <label>Content **</label>
                            <textarea id="blogContent" class="form-control summernote" name="content" rows="8" placeholder="Enter content"></textarea>
                            <p id="errcontent" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Serial Number --}}
                        <div class="form-group">
                            <label>Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" placeholder="Enter Serial Number">
                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the blog will be shown.</small></p>
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select id="tags" class="form-control select2" name="tags[]" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                @endforeach
                            </select>
                            <p id="errtags" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Meta Title --}}
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" maxlength="255" placeholder="Enter meta title">
                            <p id="errmeta_title" class="text-danger mb-0 em"></p>
                        </div>

                        {{-- Meta Keywords --}}
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" data-role="tagsinput" placeholder="e.g. blog, news, article">
                            <p id="errmeta_keywords" class="text-danger mb-0 em"></p>
                        </div>

                        {{-- Meta Description --}}
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="5" placeholder="Enter meta description"></textarea>
                            <p id="errmeta_description" class="text-danger mb-0 em"></p>
                        </div>

                        {{-- Redirect URL --}}
                        <div class="form-group">
                            <label>Redirect URL</label>
                            <input type="url" class="form-control" name="redirect_url" placeholder="https://example.com/redirect">
                            <p id="errredirect_url" class="text-danger mb-0 em"></p>
                        </div>

                        {{-- Index Page --}}
                        <div class="form-group">
                            <label>Index Page?</label>
                            <select name="is_indexed" class="form-control">
                                <option value="" selected disabled>Select indexing option</option>
                                <option value="1">Yes - index & follow</option>
                                <option value="0">No - noindex</option>
                            </select>
                            <p id="erris_indexed" class="text-danger mb-0 em"></p>
                        </div>

                        {{-- Publish Date --}}
                        <div class="form-group">
                            <label>Publish Date</label>
                            <input type="datetime-local" name="publish_data" class="form-control">
                            <p id="errpublish_data" class="text-danger mb-0 em"></p>
                        </div>

                        {{-- Canonical --}}
                        <div class="form-group">
                            <label>Canonical URL</label>
                            <input type="url" name="canonical" class="form-control" placeholder="https://example.com/original-post">
                            <p id="errcanonical" class="text-danger mb-0 em"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >Close
                    </button>
                    <button
                        id="submitBtn"
                        type="button"
                        class="btn btn-primary"
                    >Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image LFM Modal -->
    <div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
         aria-hidden="true">
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
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
            $('#createTitleInput').on('input', function() {
                if (!slugManuallyEdited) {
                    const title = $(this).val();
                    const slug = generateSlug(title);
                    $('#createSlugInput').val(slug);
                }
            });
            
            // Track when slug is manually edited
            $('#createSlugInput').on('input', function() {
                slugManuallyEdited = true;
            });
            
            // Reset manual edit flag when slug is cleared
            $('#createSlugInput').on('blur', function() {
                if ($(this).val() === '') {
                    slugManuallyEdited = false;
                }
            });

            $("select[name='language_id']").on('change', function () {

                $("#bcategory").removeAttr('disabled');

                let langid = $(this).val();
                let url = "{{url('/')}}/admins/blog/" + langid + "/getcats";
                console.log(url);
                $.get(url, function (data) {
                    console.log(data);
                    let options = `<option value="" disabled selected>Select a category</option>`;
                    for (let i = 0; i < data.length; i++) {
                        options += `<option value="${data[i].id}">${data[i].name}</option>`;
                    }
                    $("#bcategory").html(options);

                });
            });

            // make input fields RTL
            $("select[name='language_id']").on('change', function () {
                $(".request-loader").addClass("show");

                let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
                console.log(url);
                $.get(url, function (data) {
                    $(".request-loader").removeClass("show");
                    if (data == 1) {
                        $("form input").each(function () {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form select").each(function () {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form textarea").each(function () {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form .summernote").each(function () {
                            $(this).siblings('.note-editor').find('.note-editable').addClass('rtl text-right');
                        });

                    } else {
                        $("form input, form select, form textarea").removeClass('rtl');
                        $("form.modal-form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
                    }
                })
            });

            // translatable portfolios will be available if the selected language is not 'Default'
            $("#language").on('change', function () {
                let language = $(this).val();
                // console.log(language);
                if (language == 0) {
                    $("#translatable").attr('disabled', true);
                } else {
                    $("#translatable").removeAttr('disabled');
                }
            });
        });
        // console.log('loaded');
    </script>
@endsection
