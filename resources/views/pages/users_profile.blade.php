
    {{-- */ $lImage = (empty($user_image) ?
        '/'.$storage.'media/images/noavatar.png' : $user_image); /* --}}

<div class="row">
    <div class="col-sm-6">
        <img width="100px" src="{{ $lImage }}">
    </div>

    <div class="col-sm-6">
        <p>email: {{ $current_user->email }}</p>
        <p>First name: {{ (empty ($current_user->first_name) ? '-' : $current_user->first_name) }}</p>
        <p>Last name: {{ (empty ($current_user->last_name) ? '-' : $current_user->last_name) }}</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <a href="/users/edit">Редагувати</a>
    </div>
</div>