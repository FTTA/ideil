<h2>Управління Коментарями</h2>
<div class="row">

    <div class="col-sm-12">
        <div class="item_cart">

            <div class="item_cart_title">
                <a href="/articles/details/<?php echo $article->id; ?>">
                    <b width="50%"><?php echo $article->title; ?></b>
                </a>
                <p width="50%"class="item_cart_title_block_r"><?php echo $article->date_creation; ?></p>
            </div>
            <div>
                <p><?php echo $article->text; ?></p>
            </div>
        </div>
    </div>

</div>
<br>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Автор</th>
        <th>Текст</th>
        <th>Дата створення</th>
        <th>Статус</th>
    </tr>

@foreach ($comments as $lVal)
    {{-- */ $lImage = empty($lVal->user_avatar) ? $storage.'media/images/noavatar.png' : $content['users'].$lVal->user_avatar ; /* --}}

    <tr>
        <td>{{ $lVal->id }}</td>
        <td>
            <img src="/{{ $lImage }}" width="100px" /><br>
            {{ $lVal->email }}
        </td>
        <td>
            {{ $lVal->text }}
        </td>
        <td>{{ $lVal->date_creation }}<br></td>
        <td>
            {{ ($lVal->is_blocked) ? 'Прихований' : 'Видимий' }}
            <br>
            <input type="button" class="blocked"
                data-is-blocked="{{ ($lVal->is_blocked) ? '0' : '1' }}"
                data-comment-id="{{ $lVal->id }}"
                value="{{ ($lVal->is_blocked) ? 'Опублікувати' : 'Приховати' }}" />
        </td>
    </tr>


@endforeach

</table>

{{ $paginator->render() }}
