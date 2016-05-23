<h2>Управління статтями</h2>
<table class="table table-striped">
<tr>
    <th>ID</th>
    <th>Назва</th>
    <th>Коментарі</th>
    <th>Дата створення</th>
    <th>Статус</th>
</tr>
<?php

if (!empty($articles)) {
    foreach ($articles as $lVal) {
?>
<tr>
    <td><?php echo $lVal->id; ?></td>
    <td>
        <a href="/articles/edit/<?php echo $lVal->id; ?>">
            <b width="50%"><?php echo $lVal->title; ?></b>
        </a>
    </td>
    <td>
        <a href="/comments/manage/<?php echo $lVal->id; ?>" title="переглянути коментарі">коментарі</a>
    </td>
    <td><?php echo $lVal->date_creation; ?></td>
    <td>
        <?php echo ($lVal->is_published) ? 'Опубліковано' : 'Не опубліковано'; ?>
        <br>
        <input type="button" class="published"
            data-is-published="<?php echo ($lVal->is_published) ? '0' : '1'; ?>"
            data-article-id="<?php echo $lVal->id; ?>"
            value="<?php echo ($lVal->is_published) ? 'Приховати' : 'Опублікувати'; ?>" />
    </td>
</tr>

<?php
    }
}
?>
</table>

<?php echo $paginator->render(); ?>
