@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">Журнал</h1>

<h3 class="page-header">Відпущено</h3>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.date')</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.cert')</th>
      <th>@lang('apteka.serial')</th>
      <th>@lang('apteka.expire')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.client')</th>
    </tr>
  </thead>
  @foreach($outcomings as $item)
    <tr>
      <td>{{$item->date}}</td>
      <td>
        <a href="{{ route('apteka.product.show', ['id'=>$item->product->id]) }}" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')">{{$item->product->title}}</a>
      </td>
      <td>{{$item->incoming->cert}}</td>
      <td>{{$item->incoming->serial}}</td>
      <td>{{$item->incoming->expire}}</td>
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
      <th>@lang('apteka.date')</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.cert')</th>
      <th>@lang('apteka.serial')</th>
      <th>@lang('apteka.expire')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.invoice')</th>
    </tr>
  </thead>
  @foreach($incomings as $item)
    <tr>
      <td>{{$item->date}}</td>
      <td><a href="{{ route('apteka.product.show', ['id'=>$item->product->id]) }}" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')">{{$item->product->title}}</a></td>
      <td>{{$item->cert}}</td>
      <td>{{$item->serial}}</td>
      <td>{{$item->expire}}</td>
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