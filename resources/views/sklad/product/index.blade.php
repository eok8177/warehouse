@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.products')</h1>

  <span>@lang('sklad.bill'): </span>
<div class="btn-group" role="group">
  <a href="{{ route('sklad.product.index') }}" class="btn btn-default">@lang('sklad.all')</a>
  @foreach($bills as $bill)
  <a href="{{ route('sklad.product.index') }}?bill={{$bill->id}}" class="btn btn-default">{{$bill->title}}</a>
  @endforeach
</div>
<form class="form-inline pull-right" action="" method="get">
  <div class="form-group">
    <input type="hidden" name="bill" value="{{app('request')->input('bill')}}">
     <input type="text" class="form-control" id="title" name="title" placeholder="{{app('request')->input('title')}}">
  </div>
  <button type="submit" class="btn btn-default">@lang('sklad.search')</button>
</form>

<p><a href="{{ route('sklad.product.create') }}" class="btn fa fa-plus"> @lang('sklad.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.bill')</th>
      <th>Action</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.sum')</th>
      <th>@lang('sklad.averageprice')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{$item->bill->title}}</td>
      <td>
        <a href="{{ route('sklad.product.show', ['id'=>$item->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('sklad.show')"></a>
        <a href="{{ route('sklad.product.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('sklad.edit')"></a>
        @if ($item->quantity > 0)
        <a href="{{ route('sklad.outcoming.create', ['id'=>$item->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('sklad.out')"></a>
        @endif
      </td>
      <td>{{$item->title}}</td>
      <td>{{$item->measure}}</td>
      <td>{{$item->quantity}}</td>
      <td>{{$item->sum}}</td>
      <td>{{($item->quantity > 0) ? number_format($item->sum / $item->quantity, 2, '.', ' ') : ''}}</td>
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