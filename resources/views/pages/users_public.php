
<?php
    $lImage = (empty($user_image->file_name) ?
        $storage.'media/images/noavatar.png' : $content['users'].$user_image->file_name);
?>
<div class="row">
    <div class="col-sm-6">
        <img width="100px" src="/<?php echo $lImage; ?>">
    </div>

    <div class="col-sm-6">
        <p>email: <?php echo $current_user->email; ?></p>
        <p>First name: <?php echo (empty ($current_user->first_name) ? '-' : $current_user->first_name); ?></p>
        <p>Last name: <?php echo (empty ($current_user->last_name) ? '-' : $current_user->last_name); ?></p>
    </div>
</div>
