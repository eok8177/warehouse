@extends('backend.layouts.default')

@section('content')
<h1 class="page-header">@lang('messages.work')</h1>

<p>{{$work->id}}
<p>{{$work->lpz->name}}
<p>{{$work->cat->name}}
<p>{{$work->invoice}}
<p>{{$work->summ}}
<p>{{$work->description}}
<p>{{$work->created_at}}

@endsection
