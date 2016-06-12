
<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8">

    <title>{{ $title or 'Default' }}</title>

    <link href="/{{$storage}}media/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/{{$storage}}media/css/style.css" rel="stylesheet" type="text/css"/>

    @stack('styles')

    <script src="/{{ $storage }}media/js/jquery-1.11.3.min.js"></script>
    <script src="/{{ $storage }}media/js/sys_funcs.js"></script>
    <script src="/{{ $storage }}media/js/submit_and_send.js"></script>
    <script src="/{{ $storage }}media/js/common.jsexample.js"></script>
    <script src="/{{ $storage }}media/jquery-validation-1.14.0/jquery.validate.min.js"></script>
    <script src="/{{ $storage }}media/jquery-validation-1.14.0/additional-methods.js"></script>

    @stack('scripts')

</head>

<body style="height: 100%;">

    <div style="position: relative; min-height: 100%;">

            @include('header')

            @if (!empty($menu_block))
                {!! $menu_block !!}
            @endif

        <br>
        <div style="padding: 0px 15px; ">
            <div class="row">
                <div class="col-md-3">

                    @section('left_block')
                        This is the master left_block.
                    @show
                </div>

                <div class="col-md-9">
                    @yield('content_block')
                </div>
            </div>
        </div>
        <div style="height: 25px;"></div>


        @if (!empty($footer))
            {!! $footer !!}
        @endif

        @include('footer')


    </div>
        <!-- Page rendered in {exec_time}s using {mem_usage}mb of memory. -->

    <div id="uploader_template" style="display: none"> <!-- container for template -->
        <div class="row"> <!-- template -->
            <div class="col-md-3" >
                <span style="position: relative;">
                    <img src="/{{ $storage }}media/images/close.png" class="--file_delete--"
                        style="position: absolute; right: 3px;"/>
                    <img src="/--file_path--" alt="альтернативный текст" width="100px" height="100px"/>
                    <input class="form-control img_to_send"
                        type="hidden"
                        value="--file_path--"
                        name="--name_prefix--[--file_unic--][image_path]"
                        readonly="readonly" />
                </span>
            </div>
        </div>
    </div>

    <input id="csrf_token"  type="hidden" name="_token" value="{{ csrf_token() }}">

</body>
</html>
