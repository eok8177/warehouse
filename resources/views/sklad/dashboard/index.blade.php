@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">Журнал</h1>

<h3 class="page-header">Відпущено</h3>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.client')</th>
    </tr>
  </thead>
  @foreach($outcomings as $item)
    <tr>
      <td>{{$item->date}}</td>
      <td>
        <a href="{{ route('sklad.product.show', ['id'=>$item->product->id]) }}" data-toggle="tooltip" data-placement="top" title="@lang('sklad.show')">{{$item->product->title}}</a>
      </td>
      <td>{{$item->count}} {{$item->product->measure}}</td>
      <td>{{$item->client->title}}</td>
    </tr>
  @endforeach
</table>

<!-- {{ $outcomings->links() }} -->


<h3 class="page-header">Надійшло</h3>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.invoice')</th>
    </tr>
  </thead>
  @foreach($incomings as $item)
    <tr>
      <td>{{$item->date}}</td>
      <td><a href="{{ route('sklad.product.show', ['id'=>$item->product->id]) }}" data-toggle="tooltip" data-placement="top" title="@lang('sklad.show')">{{$item->product->title}}</a></td>
      <td>{{$item->count}} {{$item->product->measure}}</td>
      <td>{{$item->invoice->title}}</td>
    </tr>
  @endforeach
</table>

{{ $incomings->links() }}
@endsection

@section('scripts')
<script>
  $(function () {

  });
</script>
@endsection