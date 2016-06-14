@extends('layouts.main_template')

@push('scripts')
    <script src="/{{ $storage }}media/js/file_uploader.js"></script>
    <script src="/{{ $storage }}media/js/users_edit.js"></script>
@endpush

@section('content_block')

<form id="edit_form">
<div class="row">
    <div class="col-sm-12">
        <div id="container"></div>

        {{-- */ $lMediaItems = $current_user->getMedia(); /* --}}


        @if (!empty($lMediaItems[0]))

        {{-- */ $lImage = $storage.$lMediaItems[0]->getUrl(); /* --}}

        <div class="row old_image">
            <div class="col-md-3">
                <span style="position: relative;">
                    <img src="/{{ $storage }}media/images/close.png" class="delete_avatar"
                        style="position: absolute; right: 3px;"/>
                    <img src="{{ $lImage }}" width="100px" height="100px"/>
                    <input type="hidden"
                        value="{{ $lImage }}"
                        name="delete_user_img"
                        readonly="readonly" />
                </span>
            </div>
        </div>

        @endif


        <input type="file" id="user_image">
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
            <p>email: {{ $current_user->email }}</p>

            <p>Ім'я<br>
                <input type="text" class="form_to_send" name="name"
                    value="{{ (empty ($current_user->name) ? '' : $current_user->name) }}" />
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

@endsection
