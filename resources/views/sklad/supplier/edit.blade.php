@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.supplier')</h1>

{!! Form::model($supplier, ['route' => ['sklad.supplier.update', $supplier->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('title', Lang::get('sklad.supplier'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', $supplier->title, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('description', Lang::get('sklad.description'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('description', $supplier->description, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('sklad.save')) !!}
  </div>
{!! Form::close() !!}

@endsection