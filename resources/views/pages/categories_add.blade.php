
{{-- */  $lEditMode = (!empty($edit_mode) && !empty($category->id) && !empty($category->title))
    ? true : false; /* --}}

Додати категорію

<form id="category_form">
    <div class="form-group">
        <label for="name">Назва</label>
        <input type="text" class="form-control form_to_send"
            value="{{($lEditMode) ? $category->title : ''}}" name="title" id="name" />
    </div>

    @if ($lEditMode)

        <input type="hidden" class="form-control" value="{{$category->id}}" id="category_id" />
        <input id="edit_category" type="button" class="btn btn-default" value="Редагувати" />
        <input id="delete_category" type="button" class="btn btn-default" value="Видалити" />

    @else
        <input id="add_category" type="button" class="btn btn-default" value="Створити" />
    @endif

</form>
