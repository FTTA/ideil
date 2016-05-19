<?php

    if (!empty($edit_mode)
        && !empty($article->id)
        && !empty($article->title)
        && !empty($article->text)
    )
        $lEditMode = true;
    else
        $lEditMode = false;
?>
Додати публікацію

<form id="article_form">
    <div class="form-group">
        <label for="name">Назва</label>
        <input type="text" class="form-control form_to_send"
            value="<?php echo ($lEditMode) ? $article->title : ''; ?>"
            name="title" id="name" />
    </div>

    <div class="form-group">
        <label for="description">Опис</label>
        <input type="text" class="form-control form_to_send"
            value="<?php echo ($lEditMode) ? $article->text : ''; ?>"
            name="text" id="description" />
    </div>

<?php
    if ($lEditMode) {
?>
        <input type="hidden" class="form-control form_to_send"
            value="<?php echo $article->id; ?>"
            name="article_id" />
        <input id="edit_article" type="button" class="btn btn-default" value="Редагувати" />
        <input id="delete_article"  data-article-id="<?php echo $article->id; ?>"
            type="button" class="btn btn-default" value="Видалити" />
<?php
    }
    else {
?>
        <input id="add_article" type="button" class="btn btn-default" value="Створити" />
<?php
    }
?>
</form>
