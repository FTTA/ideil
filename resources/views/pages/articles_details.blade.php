<div class="row">



@if (!empty($article))

    <div class="col-sm-12">
        <div class="item_cart">

            <div class="item_cart_title">
                <a href="/articles/details/{{ $article->id }}">
                    <b width="50%">{{ $article->title }}</b>
                </a>
                <p width="50%"class="item_cart_title_block_r">{{ $article->date_creation }}</p>
            </div>
            <div>
                <p>{{ $article->text }}</p>
            </div>
            <p>
                <a href="/users/publicp/{{ $article->user_id }}">
                    Автор
                </a>
            </p>
            <p>

            @if (!empty($article_categories))
                Категірії:
                @foreach ($article_categories as $lVal)
                    {{ $lVal->category->title }} &nbsp&nbsp
                @endforeach
            @endif

            </p>
        </div>
    </div>

@endif
</div>
<div class="row">
    <form id="comment_form">
        <div class="col-sm-12">
            <textarea name="text" class="form-control form_to_send"
                style="resize: vertical;"></textarea>
            <input type="hidden" name="article_id" class="form_to_send"
                value="{{ $article->id }}" />
        </div>
        <div class="col-sm-12">
            <input id="add_comment" type="button" value="add comment" />
        </div>
    </form>
</div>
<br>

@foreach ($comments as $lVal)

    {{-- */ $lImage = empty($lVal->user_avatar) ?
        $storage.'media/images/noavatar.png' : $content['users'].$lVal->user_avatar ; /* --}}


<div class="row">
    <div class="col-sm-3">
        <img src="/{{ $lImage }}" width="100px" /><br>
        <a href="/users/publicp/{{ $lVal->user_id }}">
            {{ $lVal->email }}
        </a>
        <br>
        {{ $lVal->date_creation }}<br>
    </div>
    <div class="col-sm-9">
        {{ $lVal->text }}
    </div>
</div>
@endforeach

{{ $comments->render() }}

