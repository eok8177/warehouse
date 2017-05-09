@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">
  @lang('apteka.report') з {{$from}} по {{$to}}
  {!! link_to_route('apteka.report.excel', 'Export to Excel', ['from' => $from, 'to' => $to, 'type' => 'full'], ['class' => 'btn btn-info pull-right']) !!}
</h1>



@php
//echo "<pre>".print_r($report, true)."</pre>"; exit();
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

      @foreach($clients as $id => $title)
        @php
          $count = 'c_count_'.$id;
          $sum = 'c_sum_'.$id;
          if ($report->sum($sum) == 0) continue;
        @endphp
        <th colspan="2">{{$title}}</td>
      @endforeach

      <th colspan="2">Залишок на {{$to}}</th>

    </tr>
    <tr>

      <th>кіл-ть</th>
      <th>сума</th>
      <th>кіл-ть</th>
      <th>сума</th>
      <th>кіл-ть</th>
      <th>сума</th>

      @foreach($clients as $id => $title)
        @php
          $count = 'c_count_'.$id;
          $sum = 'c_sum_'.$id;
          if ($report->sum($sum) == 0) continue;
        @endphp
        <th>кіл-ть</th>
        <th>сума</th>
      @endforeach


      <th>кіл-ть</th>
      <th>сума</th>
    </tr>
  </thead>
  @foreach($report as $key => $item)
  @php
      if (($item->start_in_count - $item->start_out_count) == 0 AND ($item->end_in_count - $item->end_out_count) == 0 AND $item->out_count == 0 AND $item->in_count == 0) continue;
  @endphp
    <tr>
      <td>{{$item->bill}}</td>
      <td>{{$item->title}}</td>
      <td>{{$item->measure}}</td>
      <td>{{(($item->start_in_count - $item->start_out_count) > 0) ? number_format($item->start_in_count - $item->start_out_count, 2, ',' ,'') : ''}}</td>
      <td>{{(($item->start_in_sum - $item->start_out_sum) > 0) ? number_format($item->start_in_sum - $item->start_out_sum, 2, ',' ,'') : ''}}</td>
      <td>{{($item->in_count > 0) ? number_format($item->in_count, 2 ,',' ,'') : ''}}</td>
      <td>{{($item->in_sum > 0) ? number_format($item->in_sum, 2 ,',' ,'') : ''}}</td>
      <td>{{($item->out_count > 0) ? number_format($item->out_count, 2 ,',' ,'') : ''}}</td>
      <td>{{($item->out_sum > 0) ? number_format($item->out_sum, 2 ,',' ,'') : ''}}</td>

      @foreach($clients as $id => $title)
        @php
          $count = 'c_count_'.$id;
          $sum = 'c_sum_'.$id;
          if ($report->sum($sum) == 0) continue;
        @endphp
        <td>{{($item->$count > 0) ? number_format($item->$count, 2 , ',', '') : ''}}</td>
        <td>{{($item->$sum > 0) ? number_format($item->$sum, 2 , ',' ,'') : ''}}</td>
      @endforeach

      <td>
        {{(($item->end_in_count - $item->end_out_count) > 0 ) ? number_format($item->end_in_count - $item->end_out_count, 2, ',', '') : ''}}
      </td>
      <td>
        {{(($item->end_in_sum - $item->end_out_sum) > 0) ? number_format($item->end_in_sum - $item->end_out_sum, 2 , ',', '') : ''}}
      </td>
    </tr>
  @endforeach
  <tr>
    <td colspan="3">Всього</td>
    <td>{{(($report->sum('start_in_count') - $report->sum('start_out_count')) > 0) ? number_format($report->sum('start_in_count') - $report->sum('start_out_count'), 2, ',' ,'') : ''}}</td>
    <td>{{(($report->sum('start_in_sum') - $report->sum('start_out_sum')) > 0) ? number_format($report->sum('start_in_sum') - $report->sum('start_out_sum'), 2, ',' ,'') : ''}}</td>
    <td>{{($report->sum('in_count') > 0) ? number_format($report->sum('in_count'), 2, ',', '') : ''}}</td>
    <td>{{($report->sum('in_sum') > 0) ? number_format($report->sum('in_sum'), 2, ',', '') : ''}}</td>
    <td>{{($report->sum('out_count') > 0) ? number_format($report->sum('out_count'), 2, ',', '') : ''}}</td>
    <td>{{($report->sum('out_sum') > 0) ? number_format($report->sum('out_sum'), 2, ',', '') : ''}}</td>

    @foreach($clients as $id => $title)
      @php
        $count = 'c_count_'.$id;
        $sum = 'c_sum_'.$id;
        if ($report->sum($sum) == 0) continue;
      @endphp
      <td>{{($report->sum($count) > 0) ? number_format($report->sum($count), 2, ',', '') : ''}}</td>
      <td>{{($report->sum($sum) > 0) ? number_format($report->sum($sum), 2, ',', '') : ''}}</td>
    @endforeach

    <td>{{(($report->sum('end_in_count') - $report->sum('end_out_count')) > 0) ? number_format($report->sum('end_in_count') - $report->sum('end_out_count'), 2, ',', '') : ''}}</td>
    <td>{{(($report->sum('end_in_sum') - $report->sum('end_out_sum')) > 0) ? number_format($report->sum('end_in_sum') - $report->sum('end_out_sum'), 2, ',', '') : ''}}</td>
  </tr>

</table>

@endsection