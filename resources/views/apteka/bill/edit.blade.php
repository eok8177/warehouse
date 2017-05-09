@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.bill')</h1>

{!! Form::model($bill, ['route' => ['apteka.bill.update', $bill->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', $bill->title, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('description', Lang::get('apteka.description'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('description', $bill->description, ['class' => 'form-control']) !!}
    </div>
  </div>


  <div class="form-group">
    {!! Form::submit(Lang::get('apteka.save')) !!}
  </div>
{!! Form::close() !!}

@endsection