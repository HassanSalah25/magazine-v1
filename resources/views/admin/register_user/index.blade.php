@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">
        Registered Users
    </h4>
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
        <a href="#">Registered Users</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-title">
                        Registered Users
                    </div>
                </div>
                <div class="col-6 mt-2 mt-lg-0">
                    <button class="btn btn-danger float-right btn-sm ml-2 mt-1 d-none bulk-delete" data-href="{{route('register.user.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                    <form action="{{url()->full()}}" class="float-right">
                        <input type="text" name="term" class="form-control" value="{{request()->input('term')}}" placeholder="Search by Username / Email" style="min-width: 250px;">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($users) == 0)
                <h3 class="text-center">NO USER FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Number</th>
                        <th scope="col">Email Status</th>
                        <th scope="col">Account</th>
                        <td scope="col">Action</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $key => $user)
                        <tr>
                            <td>
                                <input type="checkbox" class="bulk-check" data-val="{{$user->id}}">
                            </td>
                          <td>{{convertUtf8($user->username)}}</td>
                          <td>{{convertUtf8($user->email)}}</td>
                          <td>
                             {{$user->number}}
                          </td>

                         <td>
    <form id="emailForm{{$user->id}}" class="d-inline-block" action="{{ route('register.user.email') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        {{-- hidden input عشان يبعت no لو الـ checkbox unchecked --}}
        <input type="hidden" name="email_verified" value="no">

        <label class="status-toggle">
            <input type="checkbox"
                   name="email_verified"
                   value="Yes"
                   onchange="document.getElementById('emailForm{{$user->id}}').submit();"
                   {{ strtolower($user->email_verified) == 'yes' ? 'checked' : '' }}>
            <div class="status-toggle-track"></div>
            <div class="status-toggle-knob">
                <div class="status-toggle-face status-toggle-face--off"></div>
                <div class="status-toggle-face status-toggle-face--on"></div>
            </div>
        </label>
    </form>
</td>

<td>
    <form id="userForm{{$user->id}}" class="d-inline-block" action="{{ route('register.user.ban') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        {{-- hidden input عشان يبعت 0 لو الـ checkbox unchecked --}}
        <input type="hidden" name="status" value="0">

        <label class="status-toggle">
            <input type="checkbox"
                   name="status"
                   value="1"
                   onchange="document.getElementById('userForm{{$user->id}}').submit();"
                   {{ $user->status == 1 ? 'checked' : '' }}>
            <div class="status-toggle-track"></div>
            <div class="status-toggle-knob">
                <div class="status-toggle-face status-toggle-face--off"></div>
                <div class="status-toggle-face status-toggle-face--on"></div>
            </div>
        </label>
    </form>
</td>

                          <td>
                            <div class="dropdown">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('register.user.view',$user->id)}}">Details</a>
                                    <a class="dropdown-item" href="{{route('register.user.changePass',$user->id)}}">Change Password</a>
                                    <form class="deleteform d-block" action="{{route('register.user.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <button type="submit" class="deletebtn">
                                        Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
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
              {{$users->appends(['term' => request()->input('term')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
