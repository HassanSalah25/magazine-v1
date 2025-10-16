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
    <h4 class="page-title">Blog Categories</h4>
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
        <a href="#">Blogs</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Categories</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Categories</div>
                </div>
                <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Blog Category</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.bcategory.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($bcategorys) == 0)
                <h3 class="text-center">NO BLOG CATEGORY FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($bcategorys as $key => $bcategory)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$bcategory->id}}">
                          </td>
                          <td>{{convertUtf8($bcategory->name)}}</td>
                          <td>
                            @if ($bcategory->status == 1)
                              <h2 class="d-inline-block"><span class="badge badge-success">Active</span></h2>
                            @else
                              <h2 class="d-inline-block"><span class="badge badge-danger">Deactive</span></h2>
                            @endif
                          </td>
                          <td>{{$bcategory->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm " href="{{ route('admin.bcategory.edit', $bcategory->id) }}" >
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.bcategory.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="bcategory_id" value="{{$bcategory->id}}">
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
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$bcategorys->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Blog Category Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Blog Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form create" action="{{route('admin.bcategory.store')}}" method="POST">
            @csrf
              <div class="form-group">
                  <label>Image **</label>
                  <div class="thumb-preview" id="thumbPreview1">
                      <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="Icon Image">
                  </div>
                  <br>
                  <input id="fileInput1" type="hidden" name="image">
                  <button id="chooseImage1" class="choose-image btn btn-primary" type="button"
                          data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>
                  <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                  <p class="em text-danger mb-0" id="errimage"></p>
              </div>

            <div class="form-group">
                <label for="">Language **</label>
                <select name="language_id" class="form-control">
                    <option value="" selected disabled>Select a language</option>
                    @foreach ($langs as $lang)
                        <option value="{{$lang->id}}">{{$lang->name}}</option>
                    @endforeach
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Name **</label>
              <input type="text" class="form-control" name="name" value="" placeholder="Enter name">
              <p id="errname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Status **</label>
              <select class="form-control ltr" name="status">
                <option value="" selected disabled>Select a status</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
              <p id="errstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Serial Number **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the blog category will be shown.</small></p>
            </div>
              {{-- 🔗 Slug --}}
              <div class="form-group">
                  <label>Slug</label>
                  <input type="text" class="form-control" name="slug" placeholder="Auto or manual slug">
                  <p class="text-danger mb-0 em" id="errslug"></p>
              </div>

              {{-- 🔁 Redirect URL --}}
              <div class="form-group">
                  <label>Redirect URL</label>
                  <input type="url" class="form-control" name="redirect_url" placeholder="https://example.com/page">
                  <p class="text-danger mb-0 em" id="errredirect_url"></p>
              </div>

              {{-- 🔍 Is Indexed --}}
              <div class="form-group">
                  <label>Index Page?</label>
                  <select name="is_indexed" class="form-control">
                      <option value="" disabled selected>Select indexing option</option>
                      <option value="1">Yes - index & follow</option>
                      <option value="0">No - noindex</option>
                  </select>
                  <p class="text-danger mb-0 em" id="erris_indexed"></p>
              </div>

              {{-- 📆 Publish Date --}}
              <div class="form-group">
                  <label>Publish Date</label>
                  <input type="datetime-local" class="form-control" name="publish_data">
                  <p class="text-danger mb-0 em" id="errpublish_data"></p>
              </div>

              {{-- 🔗 Canonical URL --}}
              <div class="form-group">
                  <label>Canonical URL</label>
                  <input type="url" class="form-control" name="canonical" placeholder="https://example.com/original-page">
                  <p class="text-danger mb-0 em" id="errcanonical"></p>
              </div>

              {{-- 🧠 Meta Title --}}
              <div class="form-group">
                  <label>Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" maxlength="255">
                  <p class="text-danger mb-0 em" id="errmeta_title"></p>
              </div>

              {{-- 🏷 Meta Keywords --}}
              <div class="form-group">
                  <label>Meta Keywords</label>
                  <textarea class="form-control" name="meta_keywords" rows="2" placeholder="e.g. category, tags, services"></textarea>
                  <p class="text-danger mb-0 em" id="errmeta_keywords"></p>
              </div>

              {{-- 📝 Meta Description --}}
              <div class="form-group">
                  <label>Meta Description</label>
                  <textarea class="form-control" name="meta_description" rows="3"></textarea>
                  <p class="text-danger mb-0 em" id="errmeta_description"></p>
              </div>

              {{-- 🧩 Parent Category --}}
              <div class="form-group">
                  <label>Parent Category</label>
                  <select name="parent_id" class="form-control">
                      <option value="" selected>No Parent</option>
                      @foreach($categories as $cat)
                          <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                  </select>
                  <p class="text-danger mb-0 em" id="errparent_id"></p>
              </div>

              {{-- 🧾 Content --}}
              <div class="form-group">
                  <label>Content</label>
                  <textarea name="content" class="form-control summernote" rows="5"></textarea>
                  <p class="text-danger mb-0 em" id="errcontent"></p>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Blog Category Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Blog Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" class="" action="{{route('admin.bcategory.update')}}" method="POST">
            @csrf
            <input id="inbcategory_id" type="hidden" name="bcategory_id" value="">
            <div class="form-group">
              <label for="">Name **</label>
              <input id="inname" type="name" class="form-control" name="name" value="" placeholder="Enter name">
              <p id="eerrname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Status **</label>
              <select id="instatus" class="form-control" name="status">
                <option value="" selected disabled>Select a status</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
              <p id="eerrstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Serial Number **</label>
              <input id="inserial_number" type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="eerrserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the blog category will be shown.</small></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Image LFM Modal -->
  <div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
      <i class="fas fa-times-circle"></i>
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-body p-0">
                  <iframe src="{{url('laravel-filemanager')}}?serial=1" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {

        // make input fields RTL
        $("select[name='language_id']").on('change', function() {
            $(".request-loader").addClass("show");
            let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
            console.log(url);
            $.get(url, function(data) {
                $(".request-loader").removeClass("show");
                if (data == 1) {
                    $("form.create input").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.create select").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.create textarea").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.create .summernote").each(function() {
                        $(this).addClass('rtl text-right');
                    });

                } else {
                    $("form.create input, form.create select, form.create textarea").removeClass('rtl');
                    $("form.create .summernote").removeClass('rtl text-right');
                }
            })
        });

    });
  </script>
@endsection
