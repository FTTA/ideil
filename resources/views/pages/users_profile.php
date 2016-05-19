
<?php
 $lImage = (empty($user_image->file_name) ? 'default' : $user_image->file_name);
?>
<div class="row">
    <div class="col-sm-6">
        <img src="<?php echo $lImage; ?>">
    </div>

    <div class="col-sm-6">
        <p>email: <?php echo $current_user->email; ?></p>
        <p>First name: <?php echo (empty ($current_user->first_name) ? '-' : $current_user->first_name); ?></p>
        <p>Last name: <?php echo (empty ($current_user->last_name) ? '-' : $current_user->last_name); ?></p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <a href="/users/edit">Редагувати</a>
    </div>
</div>