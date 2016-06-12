
@extends('layouts.main_template')

@section('content_block')

Доступ на сторінку {{ $controller.'/'.$action }} заборонено.
<br>
Необхідні права для доступу відсутні.

@endsection