@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.report')</h1>

@php
//echo "<pre>".print_r($report, true)."</pre>";
@endphp

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.product')</th>
      <th>ед.</th>
      <th>Сумма на <br>{{$data['from']}}</th>
      <th>Приход<br>кол-во</th>
      <th>Приход<br>сумма</th>
      <th>Уход<br>кол-во</th>
      <th>Уход<br>сумма</th>
      <th>Кол-во на <br>{{$data['to']}}</th>
      <th>Сумма на <br>{{$data['to']}}</th>
    </tr>
  </thead>
  @foreach($report as $key => $item)
    <tr>
      <td>{{$key}}</td>
      <td>{{$item['measure']}}</td>
      <td>{{$item['start_sum']}}</td>
      <td>{{$item['in_count']}}</td>
      <td>{{$item['in_sum']}}</td>
      <td>{{$item['out_count']}}</td>
      <td>{{$item['out_sum']}}</td>
      <td>{{$item['in_count'] - $item['out_count']}}</td>
      <td>{{$item['end_sum']}}</td>
    </tr>
  @endforeach
</table>

@endsection