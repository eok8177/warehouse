@extends('apteka.layouts.default')

@section('content')
<h2 class="page-header">@lang('apteka.bill')</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.description')</th>
    </tr>
  </thead>
    <tr>
      <td>{{$bill->title}}</td>
      <td>{{$bill->description}}</td>
    </tr>
</table>

<h2 class="page-header">@lang('apteka.products')</h2>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.measure')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.sum')</tr>
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