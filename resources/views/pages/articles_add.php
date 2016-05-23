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
<h2>Додати статтю</h2>

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
    <div class="form-group">
        <div class="row">
        <?php
            foreach ($categories as $lVal) {
                $lChecked = '';

                if ($lEditMode && !empty($article_categories)) {
                    foreach ($article_categories as $lItem) {
                        if ($lItem->category_id == $lVal->id) {
                            $lChecked = 'checked="checked"';
                            break;
                        }
                    }
                }

        ?>
            <div class="col-sm-4">
                <?php echo $lVal->title; ?>
                <input type="checkbox" class="form_to_send" <?php echo $lChecked; ?>
                    name="categories[][category_id]" value="<?php echo $lVal->id; ?>" />
            </div>
        <?php
            }
        ?>
        </div>
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
