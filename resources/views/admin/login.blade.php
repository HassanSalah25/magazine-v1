<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
  	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>{{$bs->website_title}}</title>
  	<link rel="icon" href="{{asset('assets/front/img/'.$bs->favicon)}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/login.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/css-login.css')}}">
  </head>
  <body>
   <div class="form-body">
    <div class="iofrm-layout">
        <div class="img-holder">
            <div class="bg"></div>
            <div class="info-holder">
                <img src="https://seo-wolves.com/assets/front/img/68b8a6d7c5a69.webp" alt="">
            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items with-bg">
                    <div class="website-logo-inside logo-normal">
                        <a href="{{url('/')}}">
                            <div class="logo">
                                <img class="logo-size" src="{{asset('assets/front/img/'.$bs->logo)}}" alt="">
                            </div>
                        </a>
                    </div>

                    <h3 class="font-md">Get more things done with Loggin platform.</h3>
                    <p>Access to the most powerfull tool in the entire design and web industry.</p>

                    {{-- Alerts --}}
                    @if (session()->has('alert'))
                        <div class="alert alert-danger fade show" role="alert" style="font-size: 14px;">
                            <strong>Oops!</strong> {{session('alert')}}
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form class="login-form" action="{{route('admin.auth')}}" method="POST">
                        @csrf
                        <input class="form-control" type="text" name="username" placeholder="Username" value="{{old('username')}}" required>
                        @if ($errors->has('username'))
                            <p class="text-danger text-left">{{$errors->first('username')}}</p>
                        @endif

                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <p class="text-danger text-left">{{$errors->first('password')}}</p>
                        @endif

                        <div class="form-button d-flex">
                            <button id="submit" type="submit" class="btn btn-primary">Login</button>
                            <a href="{{route('admin.forget.form')}}" class="btn btn-outline-primary">Forgot Password?</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

   


    <!-- jquery js -->
    <script src="{{asset('assets/front/js/jquery-3.3.1.min.js')}}"></script>
    <!-- popper js -->
    <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
    <!-- Bootstrap Notify -->
    <script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    @if (session()->has('warning'))
    <script>
      var content = {};

      content.message = '{{session('warning')}}';
      content.title = 'Sorry!';
      content.icon = 'fa fa-bell';

      $.notify(content,{
        type: 'warning',
        placement: {
          from: 'top',
          align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        delay: 4000,
      });
    </script>
     <script>
        "use strict"

$(window).on("load", function() {
    $('.btn-forget').on('click', function(e) {
        e.preventDefault();
        var inputField = $(this).closest('form').find('input');
        if (inputField.attr('required') && inputField.val()) {
            $('.error-message').remove();
            $('.form-items', '.form-content').addClass('hide-it');
            $('.form-sent', '.form-content').addClass('show-it');
        } else {
            $('.error-message').remove();
            $('<small class="error-message">Please fill the field.</small>').insertAfter(inputField);
        }

    });

    $('.btn-tab-next').on('click', function(e) {
        e.preventDefault();
        $('.nav-tabs .nav-item > .active').parent().next('li').find('a').trigger('click');
    });
    $('.custom-file input[type="file"]').on('change', function() {
        var filename = $(this).val().split('\\').pop();
        $(this).next().text(filename);
    });
});
    </script>
    @endif
  </body>
</html>
