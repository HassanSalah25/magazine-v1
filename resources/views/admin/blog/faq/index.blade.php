@extends('admin.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">FAQs - {{ $blog->title }}</h4>
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
                <a href="{{route('admin.blog.index')}}?language={{$blog->language->code}}">Blogs</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">FAQs</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-title d-inline-block">Manage FAQs</div>
                        </div>
                        <div class="col-lg-6">
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                               data-target="#createModal"><i class="fas fa-plus"></i> Add FAQ</a>
                            <a href="{{route('admin.blog.index')}}?language={{$blog->language->code}}" class="btn btn-secondary float-right btn-sm mr-2">
                                <i class="fas fa-arrow-left"></i> Back to Blogs
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($faqs) == 0)
                                <h3 class="text-center">NO FAQ FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3" id="basic-datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Question</th>
                                            <th scope="col">Answer</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($faqs as $key => $faq)
                                            <tr>
                                                <td>{{$faq->serial_number}}</td>
                                                <td>{{convertUtf8(strlen($faq->question) > 50 ? substr($faq->question, 0, 50) . '...' : $faq->question)}}</td>
                                                <td>{{convertUtf8(strlen($faq->answer) > 100 ? substr($faq->answer, 0, 100) . '...' : $faq->answer)}}</td>
                                                <td>
                                                    <a class="btn btn-secondary btn-sm" href="#" data-toggle="modal"
                                                       data-target="#editModal{{$faq->id}}">
                                                        <span class="btn-label">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        Edit
                                                    </a>
                                                    <form class="deleteform d-inline-block"
                                                          action="{{route('admin.blog.faq.delete')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="faq_id" value="{{$faq->id}}">
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

    <!-- Create FAQ Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="modal-form" method="POST">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">

                        {{-- Question --}}
                        <div class="form-group">
                            <label>Question **</label>
                            <input type="text" class="form-control" name="question" placeholder="Enter question">
                            <p id="errquestion" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Answer --}}
                        <div class="form-group">
                            <label>Answer **</label>
                            <textarea class="form-control summernote" name="answer" rows="5" placeholder="Enter answer"></textarea>
                            <p id="erranswer" class="mb-0 text-danger em"></p>
                        </div>

                        {{-- Serial Number --}}
                        <div class="form-group">
                            <label>Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" placeholder="Enter Serial Number">
                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the FAQ will be shown.</small></p>
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

    <!-- Edit FAQ Modals -->
    @foreach ($faqs as $faq)
        <div class="modal fade" id="editModal{{$faq->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit FAQ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ajaxForm{{$faq->id}}" class="modal-form" action="{{ route('admin.blog.faq.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="faq_id" value="{{ $faq->id }}">

                            {{-- Question --}}
                            <div class="form-group">
                                <label>Question **</label>
                                <input type="text" class="form-control" name="question" value="{{ $faq->question }}" placeholder="Enter question">
                                <p id="errquestion{{$faq->id}}" class="mb-0 text-danger em"></p>
                            </div>

                            {{-- Answer --}}
                            <div class="form-group">
                                <label>Answer **</label>
                                <textarea class="form-control summernote" name="answer" rows="5" placeholder="Enter answer">{{ $faq->answer }}</textarea>
                                <p id="erranswer{{$faq->id}}" class="mb-0 text-danger em"></p>
                            </div>

                            {{-- Serial Number --}}
                            <div class="form-group">
                                <label>Serial Number **</label>
                                <input type="number" class="form-control ltr" name="serial_number" value="{{ $faq->serial_number }}" placeholder="Enter Serial Number">
                                <p id="errserial_number{{$faq->id}}" class="mb-0 text-danger em"></p>
                                <p class="text-warning"><small>The higher the serial number is, the later the FAQ will be shown.</small></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="submitBtn{{$faq->id}}" type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Create FAQ
            $("#submitBtn").on('click', function () {
                $("#ajaxForm").submit();
            });

            $("#ajaxForm").on('submit', function (e) {
                e.preventDefault();
                $("#submitBtn").prop('disabled', true);
                $("#submitBtn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $(".em").hide();
                $(".err").hide();
                $.ajax({
                    url: "{{ route('admin.blog.faq.store') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#submitBtn").prop('disabled', false);
                        $("#submitBtn").html('Submit');
                        if (data == "success") {
                            $("#createModal").modal('hide');
                            location.reload();
                        } else {
                            $("#createModal").modal('hide');
                            for (var error in data) {
                                $("#err" + error).html(data[error][0]).show();
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        $("#submitBtn").prop('disabled', false);
                        $("#submitBtn").html('Submit');
                        $("#createModal").modal('hide');
                        location.reload();
                    }
                });
            });

            // Edit FAQ
            @foreach ($faqs as $faq)
                $("#submitBtn{{$faq->id}}").on('click', function () {
                    $("#ajaxForm{{$faq->id}}").submit();
                });

                $("#ajaxForm{{$faq->id}}").on('submit', function (e) {
                    e.preventDefault();
                    $("#submitBtn{{$faq->id}}").prop('disabled', true);
                    $("#submitBtn{{$faq->id}}").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    $(".em").hide();
                    $(".err").hide();
                    $.ajax({
                        url: "{{ route('admin.blog.faq.update') }}",
                        type: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            $("#submitBtn{{$faq->id}}").prop('disabled', false);
                            $("#submitBtn{{$faq->id}}").html('Update');
                            if (data == "success") {
                                $("#editModal{{$faq->id}}").modal('hide');
                                location.reload();
                            } else {
                                $("#editModal{{$faq->id}}").modal('hide');
                                for (var error in data) {
                                    $("#err" + error + "{{$faq->id}}").html(data[error][0]).show();
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            $("#submitBtn{{$faq->id}}").prop('disabled', false);
                            $("#submitBtn{{$faq->id}}").html('Update');
                            $("#editModal{{$faq->id}}").modal('hide');
                            location.reload();
                        }
                    });
                });
            @endforeach
        });
    </script>
@endsection
