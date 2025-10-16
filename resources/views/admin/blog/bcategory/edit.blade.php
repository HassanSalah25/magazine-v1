@extends('admin.layout')

@if(!empty($bcategory->language) && $bcategory->language->rtl == 1)
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
        <h4 class="page-title">Edit Category</h4>
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
                <a href="#">Service Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Category</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Category</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.scategory.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">

                            <form id="ajaxForm" class="modal-form edit" action="{{ route('admin.bcategory.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="bcategory_id" value="{{ $bcategory->id }}">

                                {{-- ✅ Image --}}
                                <div class="form-group">
                                    <label>Image **</label>
                                    <div class="thumb-preview" id="thumbPreview1">
                                        <img src="{{ asset('assets/front/img/service_category_icons/' . $bcategory->image) }}" alt="Icon Image">
                                    </div>
                                    <br>
                                    <input id="fileInput1" type="hidden" name="image">
                                    <button id="chooseImage1" class="choose-image btn btn-primary" type="button"
                                            data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>
                                    <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                                    <p class="em text-danger mb-0" id="errimage"></p>

                                    <!-- LFM Modal -->
                                    <div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-hidden="true">
                                        <i class="fas fa-times-circle"></i>
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <iframe src="{{ url('laravel-filemanager') }}?serial=1" style="width: 100%; height: 500px; border: none;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ✅ Language --}}
                                <div class="form-group">
                                    <label>Language **</label>
                                    <select name="language_id" class="form-control">
                                        <option value="" selected disabled>Select a language</option>
                                        @foreach ($langs as $lang)
                                            <option value="{{ $lang->id }}" {{ $lang->id == $bcategory->language_id ? 'selected' : '' }}>{{ $lang->name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                                </div>

                                {{-- ✅ Name --}}
                                <div class="form-group">
                                    <label>Name **</label>
                                    <input type="text" class="form-control" name="name" value="{{ $bcategory->name }}" placeholder="Enter name">
                                    <p id="errname" class="mb-0 text-danger em"></p>
                                </div>

                                {{-- ✅ Status --}}
                                <div class="form-group">
                                    <label>Status **</label>
                                    <select class="form-control ltr" name="status">
                                        <option value="" disabled>Select a status</option>
                                        <option value="1" {{ $bcategory->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $bcategory->status == 0 ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                    <p id="errstatus" class="mb-0 text-danger em"></p>
                                </div>

                                {{-- ✅ Serial --}}
                                <div class="form-group">
                                    <label>Serial Number **</label>
                                    <input type="number" class="form-control ltr" name="serial_number" value="{{ $bcategory->serial_number }}" placeholder="Enter Serial Number">
                                    <p id="errserial_number" class="mb-0 text-danger em"></p>
                                    <p class="text-warning"><small>The higher the serial number is, the later the category appears.</small></p>
                                </div>


                                {{-- 🔗 Slug --}}
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" class="form-control" name="slug" value="{{ $bcategory->slug }}">
                                    <p class="text-danger mb-0 em" id="errslug"></p>
                                </div>

                                {{-- 🔁 Redirect URL --}}
                                <div class="form-group">
                                    <label>Redirect URL</label>
                                    <input type="url" class="form-control" name="redirect_url" value="{{ $bcategory->redirect_url }}">
                                    <p class="text-danger mb-0 em" id="errredirect_url"></p>
                                </div>

                                {{-- 🔍 Is Indexed --}}
                                <div class="form-group">
                                    <label>Index Page?</label>
                                    <select name="is_indexed" class="form-control">
                                        <option value="" disabled>Select indexing</option>
                                        <option value="1" {{ $bcategory->is_indexed == 1 ? 'selected' : '' }}>Yes - index & follow</option>
                                        <option value="0" {{ $bcategory->is_indexed === 0 ? 'selected' : '' }}>No - noindex</option>
                                    </select>
                                    <p class="text-danger mb-0 em" id="erris_indexed"></p>
                                </div>

                                {{-- 📆 Publish Date --}}
                                <div class="form-group">
                                    <label>Publish Date</label>
                                    <input type="datetime-local" class="form-control" name="publish_data"
                                           value="{{ $bcategory->publish_data ? date('Y-m-d\TH:i', strtotime($bcategory->publish_data)) : '' }}">
                                    <p class="text-danger mb-0 em" id="errpublish_data"></p>
                                </div>

                                {{-- 🔗 Canonical URL --}}
                                <div class="form-group">
                                    <label>Canonical URL</label>
                                    <input type="url" class="form-control" name="canonical" value="{{ $bcategory->canonical }}">
                                    <p class="text-danger mb-0 em" id="errcanonical"></p>
                                </div>

                                {{-- 🧠 Meta Title --}}
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" value="{{ $bcategory->meta_title }}">
                                    <p class="text-danger mb-0 em" id="errmeta_title"></p>
                                </div>

                                {{-- 🏷 Meta Keywords --}}
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <textarea name="meta_keywords" class="form-control" rows="2">{{ $bcategory->meta_keywords }}</textarea>
                                    <p class="text-danger mb-0 em" id="errmeta_keywords"></p>
                                </div>

                                {{-- 📝 Meta Description --}}
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" class="form-control" rows="3">{{ $bcategory->meta_description }}</textarea>
                                    <p class="text-danger mb-0 em" id="errmeta_description"></p>
                                </div>

                                {{-- 🧩 Parent Category --}}
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="" selected>No Parent</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $bcategory->parent_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger mb-0 em" id="errparent_id"></p>
                                </div>

                                {{-- 🧾 Content --}}
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea name="content" class="form-control summernote">{{ $bcategory->content }}</textarea>
                                    <p class="text-danger mb-0 em" id="errcontent"></p>
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
