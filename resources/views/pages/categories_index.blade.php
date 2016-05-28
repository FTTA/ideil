<h2>Управління категоріями</h2>
<a href="/categories/add">Додати категорію</a>
<br>
<table class="table table-striped">
<tr>
    <th>ID</th>
    <th>Назва</th>
    <th></th>
</tr>


@if (!empty($categories))
    @foreach ($categories as $lVal)
<tr>
    <td>{{ $lVal->id }}</td>
    <td>
        <a href="/categories/edit/{{ $lVal->id }}">
            <b width="50%">{{ $lVal->title }}</b>
        </a>
    </td>
    <td>
        <a href="/categories/edit/{{ $lVal->id }}">
            Редагувати
        </a>
    </td>
</tr>


    @endforeach
@endif

</table>
