@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.invoice')</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.invoice_title')</th>
      <th>@lang('sklad.supplier')</th>
      <th>@lang('sklad.price')</th>
      <th>@lang('sklad.date')</th>
    </tr>
  </thead>
    <tr>
      <td>{{$invoice->title}}</td>
      <td>{{$invoice->supplier->title}}</td>
      <td>{{$invoice->products->sum('sum')}}</td>
      <td>{{$invoice->date}}</td>
    </tr>
</table>

<h3 class="page-header">@lang('sklad.products')</h1>


<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.bill')</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.price')</th>
      <th>@lang('sklad.sum')</th>
      <th>@lang('sklad.action')</th>
    </tr>
  </thead>

  @foreach($incomings as $incoming)
  <tr>
    <td>{{$incoming->product->bill->title}}</td>
    <td>{{$incoming->product->title}}</td>
    <td>{{$incoming->product->measure}}</td>
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
      @if (count($incoming->product->outcoming) == 0 OR count($incoming->product->outcoming->where('date', '>=', $incoming->date)) == 0)
      <a href="{{ route('sklad.incoming.destroy', ['id'=>$incoming->id]) }}" class="btn fa fa-trash-o delete"></a>
      @endif
      @if ($incoming->product->quantity > 0)
      <a href="{{ route('sklad.outcoming.create', ['id'=>$incoming->product->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('sklad.out')"></a>
      @endif
    </td>
  </tr>
  @endforeach
</table>

<hr>
<a href="{{ route('sklad.incoming.create', ['id'=>$invoice->id]) }}" class="ajax btn btn-default" data-toggle="modal" data-target="#incoming">@lang('sklad.add')</a>


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
      if (!confirm("@lang('sklad.confirm_delete')")) return false;
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