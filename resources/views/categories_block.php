
<h3>Категорії</h3>
<div class="row">
<?php
    foreach ($categories as $lVal) {
        $lMarker = (!empty($selected) && $lVal->id == $selected) ? 'selected_category':'';
?>
    <div class="col-sm-12">
        <a class="<?php echo $lMarker;?>" href="/?category_id=<?php echo $lVal->id; ?>">
            <?php echo $lVal->title; ?>
        </a>
    </div>
<?php

    }
?>
    <div class="col-sm-12">
        <br>
        <a href="/articles/index">Скинути</a>
    </div>
</div>
