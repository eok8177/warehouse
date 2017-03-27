@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.report') з {{$from}} по {{$to}}
    {!! link_to_route('sklad.report.excel', 'Export to Excel', ['from' => $from, 'to' => $to, 'type' => 'short'], ['class' => 'btn btn-info pull-right']) !!}
</h1>

@php
//echo "<pre>".print_r($report, true)."</pre>";
@endphp

<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th rowspan="2">Рахунок</th>
      <th rowspan="2">Найменування</th>
      <th rowspan="2">од.</th>
      <th colspan="2">Залишок на {{$from}}</th>
      <th colspan="2">Надійшло</th>
      <th colspan="2">Відпущено</th>
      <th colspan="2">Залишок на {{$to}}</th>

    </tr>
    <tr>

      <th>кіл-ть</th>
      <th>сума</th>
      <th>кіл-ть</th>
      <th>сума</th>
      <th>кіл-ть</th>
      <th>сума</th>
      <th>кіл-ть</th>
      <th>сума</th>
    </tr>
  </thead>
  @foreach($report as $key => $item)
    <tr>
      <td>{{$item->bill}}</td>
      <td>{{$item->title}}</td>
      <td>{{$item->measure}}</td>
      <td>{{$item->start_in_count - $item->start_out_count}}</td>
      <td>{{$item->start_in_sum - $item->start_out_sum}}</td>
      <td>{{$item->in_count}}</td>
      <td>{{$item->in_sum}}</td>
      <td>{{$item->out_count}}</td>
      <td>{{$item->out_sum}}</td>
      <td>{{$item->end_in_count - $item->end_out_count}}</td>
      <td>{{$item->end_in_sum - $item->end_out_sum}}</td>
    </tr>
  @endforeach
  <tr>
    <td colspan="3">Всього</td>
    <td>{{$report->sum('start_in_count') - $report->sum('start_out_count')}}</td>
    <td>{{$report->sum('start_in_sum') - $report->sum('start_out_sum')}}</td>
    <td>{{$report->sum('in_count')}}</td>
    <td>{{$report->sum('in_sum')}}</td>
    <td>{{$report->sum('out_count')}}</td>
    <td>{{$report->sum('out_sum')}}</td>
    <td>{{$report->sum('end_in_count') - $report->sum('end_out_count')}}</td>
    <td>{{$report->sum('end_in_sum') - $report->sum('end_out_sum')}}</td>
  </tr>
</table>

@endsection