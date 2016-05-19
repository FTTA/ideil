<?php

    if (!empty($edit_mode)
        && !empty($category->id)
        && !empty($category->title)
    )
        $lEditMode = true;
    else
        $lEditMode = false;
?>
Додати категорію

<form id="category_form">
    <div class="form-group">
        <label for="name">Назва</label>
        <input type="text" class="form-control form_to_send"
            value="<?php echo ($lEditMode) ? $category->title : ''; ?>"
            name="title" id="name" />
    </div>
<?php
    if ($lEditMode) {
?>
        <input type="hidden" class="form-control form_to_send"
            value="<?php echo $category->id; ?>"
            name="article_id" />
        <input id="edit_category" type="button" class="btn btn-default" value="Редагувати" />
        <input id="delete_category"  data-category-id="<?php echo $category->id; ?>"
            type="button" class="btn btn-default" value="Видалити" />
<?php
    }
    else {
?>
        <input id="add_category" type="button" class="btn btn-default" value="Створити" />
<?php
    }
?>
</form>
