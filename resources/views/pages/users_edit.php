

<form id="edit_form">
<div class="row">
    <div class="col-sm-12">
        <div id="container"></div>
    <?php
        if (!empty($user_image->file_name)) {
    ?>
        <div class="row old_image">
            <div class="col-md-3">
                <span style="position: relative;">
                    <img src="/media/images/close.png" class="delete_avatar"
                        style="position: absolute; right: 3px;"/>
                    <img src="/<?php echo $content['users'].$user_image->file_name; ?>" width="100px" height="100px"/>
                    <input type="hidden"
                        value="<?php echo $user_image->id; ?>"
                        name="delete_user_img"
                        readonly="readonly" />
                </span>
            </div>
        </div>
    <?php
        }
    ?>

        <input type="file" id="user_image">
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
            <p>email: <?php echo $current_user->email; ?></p>

            <p>Ім'я<br>
                <input type="text" class="form_to_send" name="first_name"
                    value="<?php echo (empty ($current_user->first_name) ? '' : $current_user->first_name); ?>" />
            </p>

            <p>Приізвище<br>
                <input type="text" class="form_to_send" name="last_name"
                    value="<?php echo (empty ($current_user->last_name) ? '' : $current_user->last_name); ?>" />
            </p>

            <input type="button" class="btn btn-default" id="change_data" value="Змінити дані" />
    </div>
</div>
</form>

<br>
<div class="row">
    <div class="col-sm-6">
        <p style="cursor: pointer" id="show_password_form"><b>Редагувати пароль</b></p>
        <form id="password_form" style="display: none;">

            <p>
                Пароль<br>
                <input type="text" class="form_to_send" name="password" value="" />
            </p>
            <p>
                Новий пароль<br>
                <input type="text" class="form_to_send" name="password_new" id="password_confirm" value="" />
            </p>

            <p>
                Підтвердити пароль<br>
                <input type="text" class="form_to_send" name="password_confirm" value="" />
            </p>
            <input type="button" class="btn btn-default" id="change_password" value="Змінити пароль" />
        </form>

    </div>
</div>

