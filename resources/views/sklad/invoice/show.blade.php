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
      <td>{{$invoice->price}}</td>
      <td>{{$invoice->date}}</td>
    </tr>
</table>

<h3 class="page-header">@lang('sklad.products')</h1>


<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.price')</th>
      <th>@lang('sklad.summ')</th>
      <th>@lang('sklad.action')</th>
    </tr>
  </thead>

  @php
    $summ = 0
  @endphp

  @foreach($invoice->products as $incoming)
  <tr>
    <td>{{$incoming->product->title}}</td>
    <td>{{$incoming->product->measure}}</td>
    <td>{{$incoming->count}}</td>
    <td>{{$incoming->price}}</td>
    <td>{{$incoming->count * $incoming->price}}</td>
    <td>
      <a href="{{ route('sklad.incoming.destroy', ['id'=>$incoming->id]) }}" class="btn fa fa-trash-o delete"></a>
    </td>
  </tr>
  @php
    $summ += $incoming->count * $incoming->price
  @endphp
  @endforeach
  <tr><td colspan="4"></td><td>{{$summ}}</td><td></td</tr>
</table>

<hr>
<a href="{{ route('sklad.incoming.create', ['id'=>$invoice->id]) }}" class="ajax btn btn-default" data-toggle="modal" data-target="#incoming">@lang('sklad.add')</a>


<!-- Modal -->
<div class="modal fade" id="incoming" tabindex="-1" role="dialog" aria-labelledby="incomingLabel"></div>
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
      if (!confirm('Are you sure you want to delete?')) return;
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