
<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta charset="utf-8">
    <title><?php if (!empty($title)) echo $title; ?></title>
    <?php
        if (!empty($styles)) {
            foreach ($styles as $lValue) {
    ?>
                <link href="<?php echo $lValue; ?>" rel="stylesheet" type="text/css"/>
    <?php
            }
        }

        if (!empty($scripts)) {
            foreach ($scripts as $lValue) {
    ?>
                <script src="<?php echo $lValue; ?>" type="text/javascript"></script>
    <?php
            }
        }
    ?>

</head>

<body style="height: 100%;">
    <div style="position: relative; min-height: 100%;">
    <?php
        if (!empty($header))
            echo $header;

        if (!empty($menu_block))
            echo $menu_block;
    ?>
    <br>
    <div style="padding: 0px 15px; ">
        <div class="row">
            <div class="col-md-3">
            <?php
                if (!empty($left_block))
                {
                    echo $left_block;
                }
            ?>
            </div>

            <div class="col-md-9">
            <?php
                if (!empty($content_block))
                {
                    echo $content_block;
                }
            ?>
            </div>
        </div>
    </div>
    <div style="height: 25px;"></div>

    <?php
        if (!empty($footer))
            echo $footer;

    ?>
    </div>
        <!-- Page rendered in {exec_time}s using {mem_usage}mb of memory. -->

    <div id="uploader_template" style="display: none"> <!-- container for template -->
        <div class="row"> <!-- template -->
            <div class="col-md-3" >
                <span style="position: relative;">
                    <img src="/<?php echo $storage; ?>media/images/close.png" class="--file_delete--"
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

    <input id="csrf_token"  type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

</body>
</html>
