@extends('sklad.layouts.default')

@section('content')
<h2 class="page-header">@lang('sklad.bill')</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.description')</th>
    </tr>
  </thead>
    <tr>
      <td>{{$bill->title}}</td>
      <td>{{$bill->description}}</td>
    </tr>
</table>

<h2 class="page-header">@lang('sklad.products')</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.sum')</tr>
    </tr>
  </thead>
  @foreach($bill->products as $product)
    <tr>
      <td>{{$product->title}}</td>
      <td>{{$product->measure}}</td>
      <td>{{$product->quantity}}</td>
      <td>{{$product->sum}}</td>
    </tr>
  @endforeach
</table>

@endsection