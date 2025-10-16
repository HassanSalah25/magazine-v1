<!DOCTYPE html>
<html lang="en">

<head>
    <meta
    http-equiv="Content-Type"
    content="text/html; charset=UTF-8"
    >
    <meta
    http-equiv="X-UA-Compatible"
    content="IE=edge"
    />
    <meta
    name="csrf-token"
    content="{{ csrf_token() }}"
    >
    <meta
    content='width=device-width, initial-scale=1.0, shrink-to-fit=no'
    name='viewport'
    />
    <title>{{$bs->website_title}}</title>
    <link
    rel="icon"
    href="{{asset('assets/front/img/'.$bs->favicon)}}"
    >
    @include('admin.partials.styles')
    @php
    $selLang = \App\Models\Language::where('code', request()->input('language'))->first();
    @endphp
    @if (!empty($selLang) && $selLang->rtl == 1)
    <style>
        #editModal form input,
        #editModal form textarea,
        #editModal form select {
            direction: rtl;
        }

        #editModal form .note-editor.note-frame .note-editing-area .note-editable {
            direction: rtl;
            text-align: right;
        }
    </style>
    @endif
    
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
            .switch {
                --circle-dim: 1.4em;
                font-size: 17px;
                position: relative;
                display: inline-block;
                width: 3.5em;
                height: 2em;
                }

                /* Hide default HTML checkbox */
                .switch input {
                opacity: 0;
                width: 0;
                height: 0;
                }

                /* The slider */
                .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #f5aeae;
                transition: .4s;
                border-radius: 30px;
                }

                .slider-card {
                position: absolute;
                content: "";
                height: var(--circle-dim);
                width: var(--circle-dim);
                border-radius: 20px;
                left: 0.3em;
                bottom: 0.3em;
                transition: .4s;
                pointer-events: none;
                }

                .slider-card-face {
                position: absolute;
                inset: 0;
                backface-visibility: hidden;
                perspective: 1000px;
                border-radius: 50%;
                transition: .4s transform;
                }

                .slider-card-front {
                background-color: #DC3535;
                }

                .slider-card-back {
                background-color: #379237;
                transform: rotateY(180deg);
                }

                input:checked ~ .slider-card .slider-card-back {
                transform: rotateY(0);
                }

                input:checked ~ .slider-card .slider-card-front {
                transform: rotateY(-180deg);
                }

                input:checked ~ .slider-card {
                transform: translateX(1.5em);
                }

                input:checked ~ .slider {
                background-color: #9ed99c;
                }
        </style>

        
<style>
    .status-toggle {
    --circle-dim: 1.4em;
    font-size: 17px;
    position: relative;
    display: inline-block;
    width: 3.5em;
    height: 2em;
    }

    /* Hide default HTML checkbox */
    .status-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The track */
    .status-toggle-track {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f5aeae;
    transition: .4s;
    border-radius: 30px;
    }

    /* The knob that moves */
    .status-toggle-knob {
    position: absolute;
    content: "";
    height: var(--circle-dim);
    width: var(--circle-dim);
    border-radius: 20px;
    left: 0.3em;
    bottom: 0.3em;
    transition: .4s;
    pointer-events: none;
    }

    /* faces for the flip effect */
    .status-toggle-face {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    perspective: 1000px;
    border-radius: 50%;
    transition: .4s transform;
    }

    .status-toggle-face--off {
    background-color: #DC3535;
    }

    .status-toggle-face--on {
    background-color: #379237;
    transform: rotateY(180deg);
    }

    /* checked states */
    .status-toggle input:checked ~ .status-toggle-knob .status-toggle-face--on {
    transform: rotateY(0);
    }

    .status-toggle input:checked ~ .status-toggle-knob .status-toggle-face--off {
    transform: rotateY(-180deg);
    }

    .status-toggle input:checked ~ .status-toggle-knob {
    transform: translateX(1.5em);
    }

    .status-toggle input:checked ~ .status-toggle-track {
    background-color: #9ed99c;
    }

    /* Custom Select Arrow Styling */
    .form-control.custom-select,
    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    
    .form-control.custom-select:focus,
    select.form-control:focus {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }

</style>      

    @yield('styles')

</head>

<body data-background-color="dark">

    <div class="wrapper
    @if(request()->routeIs('admin.file-manager'))
    overlay-sidebar
    @endif">

        {{-- top navbar area start --}}
        @includeif('admin.partials.top-navbar')
        {{-- top navbar area end --}}

        {{-- home page anchor start --}}
        @includeif('admin.themeHome.homePageAnchor')
        {{-- home page anchor end --}}

        {{-- side navbar area start --}}
        @includeif('admin.partials.side-navbar')
        {{-- side navbar area end --}}


        <div class="main-panel">
            <div class="content">
                <div class="page-inner @if(request()->routeIs('admin.file-manager')) p-0 @endif">
                    @yield('content')
                </div>
            </div>
            @includeif('admin.partials.footer')
        </div>

    </div>

    @include('admin.partials.scripts')

    {{-- Loader --}}
    <div class="request-loader">
        <img
        src="{{asset('assets/admin/img/loader.gif')}}"
        alt=""
        >
    </div>
    {{-- Loader --}}


    <!-- LFM Modal -->
    <div class="modal fade lfm-modal" id="lfmModalSummernote" tabindex="-1" role="dialog" aria-labelledby="lfmModalSummernoteTitle" aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
