<div class="row">

@if (!empty($articles))
    @foreach ($articles as $lVal)

        <div class="col-sm-12">
            <div class="item_cart">

                <div class="item_cart_title">
                    <a href="/articles/details/{{ $lVal->id }}">
                        <b width="50%">{{ $lVal->title }}</b>
                    </a>
                    <p width="50%"class="item_cart_title_block_r">{{ $lVal->date_creation }}</p>
                </div>
                <div>
                    <p>{{ str_limit($lVal->text, 200) }}</p>
                </div>
            </div>
        </div>

    @endforeach
@endif

</div>

{{ $paginator->render() }}
