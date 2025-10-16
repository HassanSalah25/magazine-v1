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
        <h4 class="page-title">Sections</h4>
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
                <a href="#">Sections</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Sections</div>
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
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($sections) == 0)
                                <h3 class="text-center">NO SECTION FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" class="bulk-check" data-val="all">
                                            </th>
                                            <th scope="col">Section Name</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($sections as $key => $section)
                                            @php
                                               if(isset($abs[$section['status']]))
                                                  $status = $abs[$section['status']];
                                               elseif(isset($bex[$section['status']]))
                                                  $status = $bex[$section['status']];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="bulk-check" data-val="{{ $key }}">
                                                </td>
                                                <td>{{ $section['name'] }}</td>
                                                <td>
                                                    @if(isset($status) && $section['status'])
                                                       <form id="statusForm{{$section['id']}}" class="d-inline-block" action="{{ route('admin.sections.update') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="section_id" value="{{$section['id']}}">

                                                            <label class="status-toggle">
                                                                <input type="checkbox"
                                                                    name="status"
                                                                    onchange="document.getElementById('statusForm{{$section['id']}}').submit();"
                                                                    {{ $status == 1 ? 'checked' : '' }}>
                                                                <div class="status-toggle-track"></div>
                                                                <div class="status-toggle-knob">
                                                                    <div class="status-toggle-face status-toggle-face--off"></div>
                                                                    <div class="status-toggle-face status-toggle-face--on"></div>
                                                                </div>
                                                            </label>
                                                        </form>

                                                    @endif
                                                </td>
                                                <td>
                                                    @if($section['route'])
                                                        <a href="{{ route($section['route'],['language' => $selectedLang]) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-cog"></i> Manage
                                                        </a>
                                                    @endif
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
