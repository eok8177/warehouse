@extends('sklad.layouts.default')

@section('content')
<h3 class="page-header">@lang('sklad.product')</h3>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.action')</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.sum')</th>
    </tr>
  </thead>
    <tr>
      <td>
        <a href="{{ route('sklad.product.edit', ['id'=>$product->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('sklad.edit')"></a>
        @if ($product->quantity > 0)
        <a href="{{ route('sklad.outcoming.create', ['id'=>$product->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('sklad.out')"></a>
        @endif
      </td>
      <td>{{$product->title}}</td>
      <td>{{$product->measure}}</td>
      <td>{{$product->quantity}}</td>
      <td>{{$product->sum}}</td>
    </tr>
</table>

<h3 class="page-header">@lang('sklad.incoming')</h3>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.invoice')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.price')</th>
      <th>@lang('sklad.sum')</th>
    </tr>
  </thead>
  @foreach($product->incoming as $incoming)
    <tr>
      <td>{{$incoming->created_at}}</td>
      <td>{{$incoming->invoice->title}}</td>
      <td>{{$incoming->count}} {{$product->measure}}</td>
      <td>{{$incoming->price}}</td>
      <td>{{$incoming->price * $incoming->count}}</td>
    </tr>
  @endforeach
</table>

<h3 class="page-header">@lang('sklad.outcoming')</h3>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.client')</th>
      <th>@lang('sklad.count')</th>
      <th>@lang('sklad.sum')</th>
    </tr>
  </thead>
  @foreach($product->outcoming as $outcoming)
    <tr>
      <td>{{$outcoming->created_at}}</td>
      <td>{{$outcoming->client->title}}</td>
      <td>{{$outcoming->count}} {{$product->measure}}</td>
      <td>{{$outcoming->sum}}</td>
    </tr>
  @endforeach
</table>

<!-- Modal -->
<div class="modal fade" id="outcoming" tabindex="-1" role="dialog" aria-labelledby="outcomingLabel"></div>
@endsection
