@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.invoice')</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.invoice_title')</th>
      <th>@lang('apteka.supplier')</th>
      <th>@lang('apteka.price')</th>
      <th>@lang('apteka.date')</th>
    </tr>
  </thead>
    <tr>
      <td>{{$invoice->title}}</td>
      <td>{{$invoice->supplier->title}}</td>
      <td>{{$invoice->products->sum('sum')}}</td>
      <td>{{$invoice->date}}</td>
    </tr>
</table>

<h3 class="page-header">@lang('apteka.products')</h1>


<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.bill')</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.measure')</th>
      <th>@lang('apteka.cert')</th>
      <th>@lang('apteka.serial')</th>
      <th>@lang('apteka.expire')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.price')</th>
      <th>@lang('apteka.sum')</th>
      <th>@lang('apteka.action')</th>
    </tr>
  </thead>

  @foreach($incomings as $incoming)
  <tr>
    <td>{{$incoming->product->bill->title}}</td>
    <td>{{$incoming->product->title}}</td>
    <td>{{$incoming->product->measure}}</td>
    <td>{{$incoming->cert}}</td>
    <td>{{$incoming->serial}}</td>
    <td>{{$incoming->expire}}</td>
    <td>
      {{($incoming->count > 0) ? number_format($incoming->count, 2 ,',' ,'') : ''}}
    </td>
    <td>
      {{($incoming->price > 0) ? number_format($incoming->price, 2 ,',' ,'') : ''}}
    </td>
    <td>
      {{($incoming->sum > 0) ? number_format($incoming->sum, 2 ,',' ,'') : ''}}
    </td>
    <td>
      <a href="{{ route('apteka.product.show', ['id'=>$incoming->product->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')"></a>
      @if (count($incoming->outcoming) == 0)
      <a href="{{ route('apteka.incoming.destroy', ['id'=>$incoming->id]) }}" class="btn fa fa-trash-o delete"></a>
      @endif
      @if ($incoming->rest > 0)
      <a href="{{ route('apteka.outcoming.create', ['id'=>$incoming->product->id, 'incoming'=>$incoming->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('apteka.out')"></a>
      @endif
    </td>
  </tr>
  @endforeach
</table>

<hr>
<a href="{{ route('apteka.incoming.create', ['id'=>$invoice->id]) }}" class="ajax btn btn-default" data-toggle="modal" data-target="#incoming">@lang('apteka.add')</a>


<!-- Modal -->
<div class="modal fade" id="incoming" tabindex="-1" role="dialog" aria-labelledby="incomingLabel"></div>
<div class="modal fade" id="outcoming" tabindex="-1" role="dialog" aria-labelledby="outcomingLabel"></div>
@endsection

@section('scripts')
  <script>
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.delete').on('click', function (e) {
      if (!confirm("@lang('apteka.confirm_delete')")) return false;
    e.preventDefault();
      $.post({
          type: 'DELETE',  // destroy Method
          url: $(this).attr("href")
      }).done(function (data) {
          console.log(data);
          location.reload(true);
      });
    });
  });
</script>
@endsection