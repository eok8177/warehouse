@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.report')</h1>

{!! Form::open(['route' => ['apteka.report.simple'], 'method' => 'POST', 'class' => 'form-inline']) !!}

  <div class="form-group">
    {!! Form::text('from', '', ['class' => 'form-control from']) !!}
  </div>

  <div class="form-group">
    {!! Form::text('to', '', ['class' => 'form-control to']) !!}
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('apteka.create')) !!}
  </div>
{!! Form::close() !!}



<h1 class="page-header">@lang('apteka.report_full')</h1>

{!! Form::open(['route' => ['apteka.report.full'], 'method' => 'POST', 'class' => 'form-inline']) !!}

  <div class="form-group">
    {!! Form::text('from', '', ['class' => 'form-control from']) !!}
  </div>

  <div class="form-group">
    {!! Form::text('to', '', ['class' => 'form-control to']) !!}
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('apteka.create')) !!}
  </div>
{!! Form::close() !!}
@endsection

@section('styles')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-uk.js"></script>
  <script>
  $( function() {
    $.datepicker.setDefaults($.datepicker.regional[ "uk" ]);
    $( ".from" ).datepicker({dateFormat: "yy-mm-dd"});
    $( ".to" ).datepicker({dateFormat: "yy-mm-dd"});
  } );
  </script>
@endsection