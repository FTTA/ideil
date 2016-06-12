
@extends('layouts.main_template')

@push('scripts')
    <script src="/{{ $storage }}media/js/registration_index.js"></script>
@endpush

@section('content_block')


Реєстрація

<form id="registration_form">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control form_to_send"
            name="email" id="email" />
    </div>

     <div class="form-group">
        <label for="name">Ім'я</label>
        <input type="text" class="form-control form_to_send"
            name="name" id="name" />
    </div>

    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="text" class="form-control form_to_send"
            name="password" id="password" />
    </div>

    <div class="form-group">
        <label for="password_confirm">Повторіть пароль</label>
        <input type="text" class="form-control form_to_send"
            name="password_confirm" id="password_confirm" />
    </div>

    <input id="registration" type="button" class="btn btn-default" value="Зареєструватись" />
</form>

@endsection
