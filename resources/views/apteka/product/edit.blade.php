@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.product')</h1>

{!! Form::model($product, ['route' => ['apteka.product.update', $product->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('bill_id', Lang::get('apteka.bill'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::select('bill_id', $bills, $product->bill_id, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', $product->title, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('measure', Lang::get('apteka.measure'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('measure', $product->measure, ['class' => 'form-control']) !!}
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