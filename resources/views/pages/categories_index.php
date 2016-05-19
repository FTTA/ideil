<a href="/categories/add">Додати категорію</a>
<br>
<table class="table table-striped">
<tr>
    <th>ID</th>
    <th>Назва</th>
    <th></th>
</tr>
<?php

if (!empty($categories)) {
    foreach ($categories as $lVal) {
?>
<tr>
    <td><?php echo $lVal->id; ?></td>
    <td>
        <a href="/categories/edit/<?php echo $lVal->id; ?>">
            <b width="50%"><?php echo $lVal->title; ?></b>
        </a>
    </td>
    <td>
        <a href="/categories/edit/<?php echo $lVal->id; ?>">
            Редагувати
        </a>
    </td>
</tr>

<?php
    }
}
?>
</table>
