@extends('layouts.main_template')

@section('content_block')

    {{-- */ $lImage = (empty($user_image) ?
        '/'.$storage.'media/images/noavatar.png' : $user_image); /* --}}

<div class="row">
    <div class="col-sm-6">
        <img width="100px" src="{{ $lImage }}">
    </div>

    <div class="col-sm-6">
        <p>email: {{ $current_user->email }}</p>
        <p>Name: {{ (empty ($current_user->name) ? '-' : $current_user->name) }}</p>

    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <a href="/users/edit">Редагувати</a>
    </div>
</div>

@endsection
