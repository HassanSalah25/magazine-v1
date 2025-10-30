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
        <h4 class="page-title">Blog Carousel Management</h4>
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
                <a href="#">Carousel Management</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Blog Carousel Management</div>
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
                            <a href="{{ route('admin.blog.index') }}?language={{ request()->input('language') }}" class="btn btn-primary float-right btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Blogs
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                <strong>Instructions:</strong> 
                                <ul class="mb-0 mt-2">
                                    <li>Toggle the "Show in Carousel" switch to add/remove blogs from the homepage carousel</li>
                                    <li>Use the "Carousel Order" field to set the display order (lower numbers appear first)</li>
                                    <li>Only blogs with "Show in Carousel" enabled will appear on the homepage</li>
                                </ul>
                            </div>
                            
                            @if (count($all_blogs) == 0)
                                <h3 class="text-center">NO BLOGS FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Show in Carousel</th>
                                            <th scope="col">Carousel Order</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($all_blogs as $key => $blog)
                                            <tr class="{{ $blog->show_in_carousel ? 'table-success' : '' }}">
                                                <td>
                                                    <img src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                                         alt="" width="80" class="rounded">
                                                </td>
                                                <td>
                                                    <strong>{{convertUtf8($blog->title)}}</strong>
                                                    @if($blog->show_in_carousel)
                                                        <span class="badge badge-success ml-2">In Carousel</span>
                                                    @endif
                                                </td>
                                                <td>{{convertUtf8($blog->bcategory->name)}}</td>
                                                <td>
                                                   <form id="carouselForm{{$blog->id}}" class="d-inline-block" action="{{ route('admin.carousel.toggle') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
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
                                                    <form id="carouselOrderForm{{$blog->id}}" class="d-inline-block" action="{{ route('admin.carousel.order') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                        <input type="number" 
                                                               name="carousel_order" 
                                                               value="{{ $blog->carousel_order }}" 
                                                               min="0" 
                                                               max="999" 
                                                               class="form-control form-control-sm" 
                                                               style="width: 80px; display: inline-block;"
                                                               onchange="document.getElementById('carouselOrderForm{{$blog->id}}').submit();">
                                                    </form>
                                                </td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm"
                                                       href="{{route('admin.blog.edit', $blog->id) . '?language=' . request()->input('language')}}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
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

    <!-- Carousel Preview Section -->
    @if(count($carousel_blogs) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Main Carousel Preview</h4>
                    <p class="text-muted">This is how your main carousel will appear on the homepage</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($carousel_blogs as $blog)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" 
                                     class="card-img-top" 
                                     alt="{{convertUtf8($blog->title)}}" 
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{convertUtf8($blog->title)}}</h6>
                                    <p class="card-text">
                                        <small class="text-muted">Carousel Order: {{$blog->carousel_order}}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Add some visual feedback for form submissions
            $('form[id^="carouselForm"], form[id^="carouselOrderForm"]').on('submit', function() {
                $(this).closest('tr').addClass('table-warning');
                setTimeout(() => {
                    $(this).closest('tr').removeClass('table-warning');
                }, 2000);
            });
        });
    </script>
@endsection
