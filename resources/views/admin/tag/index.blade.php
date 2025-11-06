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
        <h4 class="page-title">Tags</h4>
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
                <a href="#">Tags</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Tags</div>
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
                            <a href="{{route('admin.tag.create') . '?language=' . request()->input('language')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Tag</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.tag.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($tags) == 0)
                                <h3 class="text-center">NO PORTFOLIO FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">Featured Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Featured</th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($tags as $key => $tag)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check" data-val="{{$tag->id}}">
                                                </td>
                                                <td><img src="{{asset('assets/front/img/tags/featured/'.$tag->image)}}" width="80"></td>
                                                <td>{{strlen(convertUtf8($tag->title)) > 200 ? convertUtf8(substr($tag->title, 0, 200)) . '...' : convertUtf8($tag->title)}}</td>
                                                 <td>
                                                   <form id="featureForm{{$tag->id}}" class="d-inline-block" action="{{ route('admin.tag.feature') }}" method="post">
    @csrf
    <input type="hidden" name="tag_id" value="{{ $tag->id }}">
    {{-- hidden input عشان يبعت 0 لو الـ checkbox unchecked --}}
    <input type="hidden" name="feature" value="0">

    <label class="status-toggle">
        <input type="checkbox"
               name="feature"
               value="1"
               onchange="document.getElementById('featureForm{{$tag->id}}').submit();"
               {{ $tag->feature == 1 ? 'checked' : '' }}>
        <div class="status-toggle-track"></div>
        <div class="status-toggle-knob">
            <div class="status-toggle-face status-toggle-face--off"></div>
            <div class="status-toggle-face status-toggle-face--on"></div>
        </div>
    </label>
</form>

                                                </td>
                                                <td>{{$tag->serial_number}}</td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm" href="{{route('admin.tag.edit', $tag->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                                                        Edit
                                                    </a>
                                                    <form class="deleteform d-inline-block" action="{{route('admin.tag.delete')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="tag_id" value="{{$tag->id}}">
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

@endsection
