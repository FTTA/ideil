<div class="header_tempalte">
    <div style="padding: 0px 15px">
        <div class="row">
            <div class="col-md-6">
                <div class="header_block">
                    <h3 class="header_title">
                        <a href="/" class="green_text">Ideil</a>
                    </h3>
                    <p class="slogan_tyle">test</p>
                </div>
            </div>
            <div class="col-md-2">

            </div>

            <div class="col-md-4">

            @if ($is_logged)

                <p class="slogan_tyle">
                    <a href="/users/profile">{{ $current_user->email }}</a>
                </p>
                <input type="button" class="btn btn-default" id="sign_out" value="Вийти"/>
            @else
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
            @endif
            </div>
        </div>
    </div>
</div>
