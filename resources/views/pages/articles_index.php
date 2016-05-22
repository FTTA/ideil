<div class="row">
<?php

if (!empty($articles)) {
    foreach ($articles as $lVal) {
?>
        <div class="col-sm-12">
            <div class="item_cart">

                <div class="item_cart_title">
                    <a href="/articles/details/<?php echo $lVal->id; ?>">
                        <b width="50%"><?php echo $lVal->title; ?></b>
                    </a>
                    <p width="50%"class="item_cart_title_block_r"><?php echo $lVal->date_creation; ?></p>
                </div>
                <div>
                    <p><?php echo str_limit($lVal->text, 200); ?></p>
                </div>
            </div>
        </div>
<?php
    }
}
?>
</div>

<?php echo $paginator->render(); ?>
