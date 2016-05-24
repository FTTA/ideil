<div class="row">
<?php
/*
$comments = [
    [
        'user_id' => '1',
        'username' => 'bob',
        'date_creation' => '2016-11-1',
        'text'  =>'asdasd asdasd asdasd asdasd asdasd'
    ],
    [
        'user_id' => '1',
        'username' => 'bob',
        'date_creation' => '2016-11-1',
        'text'  =>'asdasd asdasd asdasd asdasd asdasd'
    ],
];*/

if (!empty($article)) {
?>
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
            <p>
                <a href="/users/publicp/<?php echo $article->user_id; ?>">
                    Автор
                </a>
            </p>
            <p>
            <?php
            if (!empty($article_categories)) {
                echo 'Категірії: ';
                foreach ($article_categories as $lVal) {
                    echo $lVal->title.'&nbsp&nbsp';
                }
            }
            ?>
            </p>
        </div>
    </div>

<?php
}
?>
</div>
<div class="row">
    <form id="comment_form">
        <div class="col-sm-12">
            <textarea name="text" class="form-control form_to_send"
                style="resize: vertical;"></textarea>
            <input type="hidden" name="article_id" class="form_to_send"
                value="<?php echo $article->id;?>" />
        </div>
        <div class="col-sm-12">
            <input id="add_comment" type="button" value="add comment" />
        </div>
    </form>
</div>
<br>
<?php
foreach ($comments as $lVal) {
    $lImage = empty($lVal->user_avatar) ? $storage.'media/images/noavatar.png' : $content['users'].$lVal->user_avatar ;
?>

<div class="row">
    <div class="col-sm-3">
        <img src="/<?php echo $lImage; ?>" width="100px" /><br>
        <a href="/users/publicp/<?php echo $lVal->user_id; ?>">
            <?php echo $lVal->email; ?>
        </a>
        <br>
        <?php echo $lVal->date_creation; ?><br>
    </div>
    <div class="col-sm-9">
        <?php echo $lVal->text; ?>
    </div>
</div>
<?php
}

echo $paginator->render();
?>
