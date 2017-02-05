@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.supplier')</h1>

{!! Form::open(['route' => ['sklad.supplier.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('title', Lang::get('sklad.title'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('description', Lang::get('sklad.description'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
    {!! Form::text('description', '', ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('sklad.save')) !!}
  </div>
{!! Form::close() !!}
@endsection