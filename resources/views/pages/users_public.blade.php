
    {{-- */ $lImage = (empty($user_image->file_name) ?
        $storage.'media/images/noavatar.png' : $content['users'].$user_image->file_name); /* --}}

<div class="row">
    <div class="col-sm-6">
        <img width="100px" src="/{{ $lImage }}">
    </div>

    <div class="col-sm-6">
        <p>email: {{ $current_user->email }}</p>
        <p>First name: {{ (empty ($current_user->first_name) ? '-' : $current_user->first_name) }}</p>
        <p>Last name: {{ (empty ($current_user->last_name) ? '-' : $current_user->last_name) }}</p>
    </div>
</div>
