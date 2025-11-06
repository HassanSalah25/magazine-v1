@extends('admin.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select,
            select {
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
        <h4 class="page-title">Nav & Tab Section</h4>
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
                <a href="#">Home Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Nav & Tab Section</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Nav & Tab Section</div>
                        </div>
                        <div class="col-lg-2">
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
                    </div>
                </div>
                <div class="card-body pt-5 pb-4">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <form id="ajaxForm" action="{{route('admin.nav_tab.update', $lang_id)}}" method="post">
                                @csrf
                                <!-- Dynamic Title & Text Pairs -->
                                <div class="form-group">
                                    <label>Nav & Tab Section</label>
                                    <div id="repeater">
                                        @if (!empty($abex->nav_tab))
                                            @foreach (json_decode($abex->nav_tab, true) as $key => $point)
                                                <div class="repeater-item mb-3 d-flex flex-column align-items-start gap-2">
                                                    <input type="text" name="points[{{ $key }}][title]"
                                                           class="form-control" placeholder="Title"
                                                           value="{{ $point['title'] }}">
                                                    <textarea id="blogContent" class="form-control summernote"
                                                              name="points[{{ $key }}][text]"
                                                              data-height="200"
                                                              placeholder="Enter content">{{ $point['text'] }}</textarea>
                                                    <button type="button" class="btn btn-danger remove-point">X</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="repeater-item mb-3 d-flex flex-column align-items-start gap-2">
                                                <input type="text" name="points[0][title]" class="form-control"
                                                       placeholder="Title">
                                                <textarea id="blogContent" class="form-control summernote"
                                                          name="points[0][text]"
                                                          data-height="200"
                                                          placeholder="Enter content"></textarea>                                                <button type="button" class="btn btn-danger remove-point">X</button>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-primary mt-2" id="add-point">+ Add Point</button>

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
        let pointIndex = {{ !empty($abex->nav_tab) ? count(json_decode($abex->nav_tab, true)) : 1 }};

        document.getElementById('add-point').addEventListener('click', () => {
            const repeater = document.getElementById('repeater');
            const wrapper = document.createElement('div');
            wrapper.classList.add('repeater-item', 'mb-3', 'd-flex', 'flex-column', 'gap-2'); // stack inputs vertically

            wrapper.innerHTML = `
            <input type="text" name="points[${pointIndex}][title]" class="form-control mb-2" placeholder="Title">
            <textarea class="form-control summernote" name="points[${pointIndex}][text]" placeholder="Enter content"></textarea>
            <button type="button" class="btn btn-danger remove-point align-self-start mt-2">X</button>
        `;

            repeater.appendChild(wrapper);

            // Re-initialize Summernote on the newly added textarea
            $(wrapper).find('.summernote').summernote({
                height: 200
            });

            pointIndex++;
        });

        // Remove button logic (still good)
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-point')) {
                $(e.target).closest('.repeater-item').remove();
            }
        });
    </script>


@endsection
