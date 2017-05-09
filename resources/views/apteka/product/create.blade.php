@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.product')</h1>

{!! Form::open(['route' => ['apteka.product.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('bill_id', Lang::get('apteka.bill'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::select('bill_id', $bills, false, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('measure', Lang::get('apteka.measure'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
    {!! Form::text('measure', '', ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('apteka.save')) !!}
  </div>
{!! Form::close() !!}

@endsection

@section('scripts')
<script>
  $(function () {

  });
</script>
@endsection



