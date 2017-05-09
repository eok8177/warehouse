@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.products')</h1>

  <span>@lang('apteka.bill'): </span>
<div class="btn-group" role="group">
  <a href="{{ route('apteka.product.index') }}" class="btn btn-default">@lang('apteka.all')</a>
  @foreach($bills as $bill)
  <a href="{{ route('apteka.product.index') }}?bill={{$bill->id}}" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="{{$bill->description}}">{{$bill->title}}</a>
  @endforeach
</div>
<form class="form-inline pull-right" action="" method="get">
  <div class="form-group">
    <input type="hidden" name="bill" value="{{app('request')->input('bill')}}">
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
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.sum')</th>
      <th>@lang('apteka.averageprice')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{($item->bill) ? $item->bill->title : ''}}</td>
      <td>
        <a href="{{ route('apteka.product.show', ['id'=>$item->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')"></a>
        <a href="{{ route('apteka.product.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('apteka.edit')"></a>
        @if ($item->quantity > 0)
        <a href="{{ route('apteka.outcoming.create', ['id'=>$item->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('apteka.out')"></a>
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