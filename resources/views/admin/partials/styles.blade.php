
<script src="{{asset('assets/admin/js/plugin/webfont/webfont.min.js')}}"></script>
<script>
  WebFont.load({
    google: {"families":["Lato:300,400,700,900"]},
    custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset('assets/admin/css/fonts.min.css')}}']},
    active: function() {
      sessionStorage.fonts = true;
    }
  });
</script>


<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome-iconpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.dm-uploader.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-datepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.timepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/atlantis.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/admin/css/custom.css')}}">


  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/remixicon.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/bootstrap.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/apexcharts.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/dataTables.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/editor-katex.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/editor.atom-one-dark.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/editor.quill.snow.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/flatpickr.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/full-calendar.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/magnific-popup.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/slick.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/prism.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/file-upload.css') }}">
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/lib/audioplayer.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="stylesheet" href="{{ asset('admin-asset/assets/css/style.css') }}">

@yield('styles')
