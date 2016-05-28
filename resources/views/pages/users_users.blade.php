<h2>Користувачі</h2>
<div class="row">

@if (!empty($users))
    @foreach ($users as $lVal)
        {{-- */ $lImage = $storage.'media/images/noavatar.png'; /* --}}
        @foreach ($users_img as $lImg)
            @if ($lImg->user_id == $lVal->id)
                {{-- */ $lImage = $content['users'].$lImg->file_name; /* --}}
                @break;
            @endif
        @endforeach

        <div class="col-sm-12">
            <div class="item_cart">

                <div class="item_cart_title">
                    <a href="/users/publicp/{{ $lVal->id }}">
                        <b width="50%">{{ $lVal->email }}</b>
                    </a>
                    <p width="50%"class="item_cart_title_block_r">
                        {{ ($lVal->is_confirmed) ? 'confirmed' : 'no confirmed' }}

                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <img width="100px" src="/{{ $lImage }}">
                    </div>
                    <div class="col-sm-6">
                        <br>Ім'я: {{ (empty($lVal->first_name)) ? '--' : $lVal->first_name }}
                        <br>Прізвище: {{ (empty($lVal->last_name)) ? '--' : $lVal->last_name }}

                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endif

</div>

{{ $paginator->render() }}
