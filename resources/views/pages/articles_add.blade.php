
    @if (!empty($edit_mode)
        && !empty($article->id)
        && !empty($article->title)
        && !empty($article->text)
    )
        {{-- */ $lEditMode = true; /* --}}
    @else
        {{-- */ $lEditMode = false; /* --}}
    @endif



<h2>Додати статтю</h2>

<form id="article_form">
    <div class="form-group">
        <label for="name">Назва</label>
        <input type="text" class="form-control form_to_send"
            value="@if ($lEditMode){{$article->title}}@endif"
            name="title" id="name" />
    </div>

    <div class="form-group">
        <label for="description">Опис</label>
        <textarea type="text" class="form-control form_to_send" style="resize: vertical;"
            name="text" id="description">@if ($lEditMode){{$article->text}}@endif</textarea>
    </div>
    <div class="form-group">
        <div class="row">

            @foreach ($categories as $lVal)
                {{-- */ $lChecked = ''; /* --}}

                @if ($lEditMode && !empty($article_categories))
                    @foreach ($article_categories as $lItem)
                        @if ($lItem->category_id == $lVal->id)
                            {{-- */ $lChecked = 'checked="checked"'; /* --}}
                            @break
                        @endif
                    @endforeach
                @endif


            <div class="col-sm-4">
                {{$lVal->title}}
                <input type="checkbox" class="form_to_send" {{$lChecked}}
                    name="categories[][category_id]" value="{{$lVal->id}}" />
            </div>

            @endforeach

        </div>
    </div>




    @if ($lEditMode)

        <input type="hidden" class="form-control"
            value="{{$article->id}}" id="article_id" />
        <input id="edit_article" type="button" class="btn btn-default" value="Редагувати" />
        <input id="delete_article"  data-article-id="{{$article->id}}"
            type="button" class="btn btn-default" value="Видалити" />
    @else

        <input id="add_article" type="button" class="btn btn-default" value="Створити" />

    @endif

</form>
