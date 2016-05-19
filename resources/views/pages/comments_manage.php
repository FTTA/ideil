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
                <p>Категорія: <?php echo $article->text; ?></p>
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
<?php
foreach ($comments as $lVal) {
    $lImage = empty($lVal->user_avatar) ? '/media/images/noavatar.png' : $content['users'].$lVal->user_avatar ;
?>
    <tr>
        <td><?php echo $lVal->id; ?></td>
        <td>
            <img src="/<?php echo $storage.$lImage; ?>" width="100px" /><br>
            <?php echo $lVal->email; ?>
        </td>
        <td>
            <?php echo $lVal->text; ?>
        </td>
        <td><?php echo $lVal->date_creation; ?><br></td>
        <td>
            <?php echo ($lVal->is_blocked) ? 'Прихований' : 'Видимий'; ?>
            <br>
            <input type="button" class="blocked"
                data-is-blocked="<?php echo ($lVal->is_blocked) ? '0' : '1'; ?>"
                data-comment-id="<?php echo $lVal->id; ?>"
                value="<?php echo ($lVal->is_blocked) ? 'Опублікувати' : 'Приховати'; ?>" />
        </td>
    </tr>

<?php
}
?>
</table>

<?php echo $paginator->render(); ?>
