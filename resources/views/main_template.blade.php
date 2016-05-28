
<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8">

    <title>{{ $title or 'Default' }}</title>

        @if (!empty($styles))
            @foreach ($styles as $lValue)

                <link href="{{ $lValue }}" rel="stylesheet" type="text/css"/>

            @endforeach
        @endif

</head>

<body style="height: 100%;">

    <div style="position: relative; min-height: 100%;">

            @if (!empty($header))
                {!! $header !!}
            @endif



            @if (!empty($menu_block))
                {!! $menu_block !!}
            @endif

        <br>
        <div style="padding: 0px 15px; ">
            <div class="row">
                <div class="col-md-3">

                    @if (!empty($left_block))
                        {!! $left_block !!}
                    @endif
                </div>

                <div class="col-md-9">

                    @if (!empty($content_block))
                        {!! $content_block !!}
                    @endif
                </div>
            </div>
        </div>
        <div style="height: 25px;"></div>


        @if (!empty($footer))
            {!! $footer !!}
        @endif


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

     @if (!empty($scripts))
        @foreach ($scripts as $lValue)
            <script src="{{ $lValue }}" type="text/javascript"></script>
        @endforeach
    @endif

</body>
</html>
