@extends('apteka.layouts.default')

@section('content')
<h2 class="page-header">@lang('apteka.supplier'): {{$supplier->title}}</h2>

<h3 class="page-header">@lang('apteka.invoices')</h3>

@foreach($supplier->invoices as $invoice)
<h4 class="page-header"><small>{{$invoice->created_at}} :</small>  {{$invoice->title}}</h4>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.measure')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.price')</th>
      <th>@lang('apteka.sum')</th>
    </tr>
  </thead>
  @foreach($invoice->products as $incoming)
    <tr>
      <td>{{$incoming->product->title}}</td>
      <td>{{$incoming->product->measure}}</td>
      <td>{{$incoming->count}}</td>
      <td>{{$incoming->price}}</td>
      <td>{{$incoming->count * $incoming->price}}</td>
    </tr>
  @endforeach
</table>
@endforeach

@endsection