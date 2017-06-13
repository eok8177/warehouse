@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.products')</h1>

  <span>@lang('apteka.bill'): </span>
<div class="btn-group" role="group">
  <a href="{{ route('apteka.product.index') }}?rest=0" class="btn btn-default">@lang('apteka.all')</a>
  @foreach($bills as $bill)
  <a href="{{ route('apteka.product.index') }}?bill={{$bill->id}}" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="{{$bill->description}}">{{$bill->title}}</a>
  @endforeach
</div>
<form class="form-inline pull-right" action="" method="get">
  <div class="form-group">
    <input type="hidden" name="bill" value="{{app('request')->input('bill')}}">
    <input type="hidden" name="rest" value="{{app('request')->input('rest')}}">
    <input type="text" class="form-control" id="title" name="title" placeholder="{{app('request')->input('title')}}">
  </div>
  <button type="submit" class="btn btn-default">@lang('apteka.search')</button>
</form>

<p><a href="{{ route('apteka.product.create') }}" class="btn fa fa-plus"> @lang('apteka.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.bill')</th>
      <th>Action</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.measure')</th>

      <th>@lang('apteka.cert')</th>
      <th>@lang('apteka.serial')</th>
      <th>@lang('apteka.expire')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.sum')</th>
      <th>@lang('apteka.averageprice')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{($item->product->bill) ? $item->product->bill->title : ''}}</td>
      <td>
        <a href="{{ route('apteka.product.show', ['id'=>$item->product->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')"></a>
        <a href="{{ route('apteka.product.edit', ['id'=>$item->product->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('apteka.edit')"></a>
        @if ($item->rest > 0)
        <a href="{{ route('apteka.outcoming.create', ['id'=>$item->product->id, 'incoming'=>$item->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('apteka.out')"></a>
        @endif
      </td>
      <td>{{$item->product->title}}</td>
      <td>{{$item->product->measure}}</td>
      <td>{{$item->cert}}</td>
      <td>{{$item->serial}}</td>
      <td>{{$item->expire}}</td>

      <td>{{$item->rest}}</td>
      <td>{{$item->rest * $item->price}}</td>
      <td>{{($item->rest > 0) ? number_format($item->price, 2, '.', ' ') : ''}}</td>
    </tr>
  @endforeach
</table>


<!-- Modal -->
<div class="modal fade" id="outcoming" tabindex="-1" role="dialog" aria-labelledby="outcomingLabel"></div>
@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection