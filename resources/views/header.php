<div class="header_tempalte">
    <div style="padding: 0px 15px">
        <div class="row">
            <div class="col-md-6">
                <div class="header_block">
                    <h3 class="header_title">
                        <a href="/" class="green_text">Fair price</a>
                    </h3>
                    <p class="slogan_tyle">Контролюймо чесну ціну. Бо хто ж як не ми, кому ж як не нам?</p>
                </div>
            </div>
            <div class="col-md-2">

            </div>

            <div class="col-md-4">

                <?php
                if ($is_logged) {
                ?>
                    <p class="slogan_tyle">
                        <a href="/users/profile"><?php echo $current_user->username; ?></a>
                    </p>
                    <input type="button" class="btn btn-default" id="sign_out" value="Вийти"/>
                <?php

                }
                else {
                ?>
                <div class="col-md-12">
                    <form id="login_form" class="form-inline">
                        <div class="form-group">
                            <input class="form_to_send form-control"  name="email" placeholder="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form_to_send form-control" name="password"
                                placeholder="Пароль">
                        </div>
                        <input type="button" class="btn btn-default" id="sign_in" value="Увійти"/>
                        <a href="/registration/index">Реєстрація</a>
                    </form>
                </div>
                <?php
                }

                ?>
            </div>
        </div>
    </div>
</div>
