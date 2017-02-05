@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.client')</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.description')</th>
    </tr>
  </thead>
    <tr>
      <td>{{$client->title}}</td>
      <td>{{$client->description}}</td>
    </tr>
</table>

<h2 class="page-header">@lang('sklad.products')</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.sum')</tr>
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