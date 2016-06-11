<h2>Користувачі</h2>
<div class="row">

@if (!empty($users))
    @foreach ($users as $lUser)

        {{-- */ $lMediaItems = $lUser->getMedia(); /* --}}
        {{-- */ $lImage = $lMediaItems[0]->getUrl(); /* --}}

        @if (empty($lImage)
            {{-- */ $lImage = '/'.$storage.'media/images/noavatar.png'; /* --}}
        @endif

        <div class="col-sm-12">
            <div class="item_cart">

                <div class="item_cart_title">
                    <a href="/users/publicp/{{ $lUser->id }}">
                        <b width="50%">{{ $lUser->email }}</b>
                    </a>
                    <p width="50%"class="item_cart_title_block_r">
                        {{ ($lUser->is_confirmed) ? 'confirmed' : 'no confirmed' }}

                    </p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <img width="100px" src="/{{ $lImage }}">
                    </div>
                    <div class="col-sm-6">
                        <br>Ім'я: {{ (empty($lUser->first_name)) ? '--' : $lUser->first_name }}
                        <br>Прізвище: {{ (empty($lUser->last_name)) ? '--' : $lUser->last_name }}

                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endif

</div>

{{ $paginator->render() }}
