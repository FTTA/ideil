@extends('layouts.main_template')


@push('scripts')
    <script src="/{{ $storage }}media/js/articles_manage.js"></script>
@endpush

@section('content_block')

<h2>Управління статтями</h2>
<table class="table table-striped">
<tr>
    <th>ID</th>
    <th>Назва</th>
    <th>Коментарі</th>
    <th>Дата створення</th>
    <th>Статус</th>
</tr>

@if (!empty($articles))
    @foreach ($articles as $lVal)

<tr>
    <td>{{ $lVal->id }}</td>
    <td>
        <a href="/articles/edit/{{ $lVal->id }}">
            <b width="50%">{{ $lVal->title }}</b>
        </a>
    </td>
    <td>
        <a href="/comments/manage/{{ $lVal->id }}" title="переглянути коментарі">коментарі</a>
    </td>
    <td>{{ $lVal->date_creation }}</td>
    <td>
        {{ ($lVal->is_published) ? 'Опубліковано' : 'Не опубліковано' }}
        <br>
        <input type="button" class="published"
            data-is-published="{{ ($lVal->is_published) ? '0' : '1' }}"
            data-article-id="{{ $lVal->id }}"
            value="{{ ($lVal->is_published) ? 'Приховати' : 'Опублікувати' }}" />
    </td>
</tr>

    @endforeach
@endif

</table>

{{ $articles->render() }}

@endsection
