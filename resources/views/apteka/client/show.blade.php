@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.client')</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.description')</th>
    </tr>
  </thead>
    <tr>
      <td>{{$client->title}}</td>
      <td>{{$client->description}}</td>
    </tr>
</table>

<h2 class="page-header">@lang('apteka.products')</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.date')</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.measure')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.sum')</tr>
    </tr>
  </thead>
  @foreach($client->outcoming as $outcoming)
    <tr>
      <td>{{$outcoming->created_at}}</td>
      <td>{{$outcoming->product->title}}</td>
      <td>{{$outcoming->product->measure}}</td>
      <td>{{$outcoming->count}}</td>
      <td>{{$outcoming->sum}}</td>
    </tr>
  @endforeach
</table>

@endsection