@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.client')</h1>

{!! Form::model($client, ['route' => ['apteka.client.update', $client->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('title', Lang::get('apteka.client_title'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', $client->title, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('description', Lang::get('apteka.description'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('description', $client->description, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('apteka.save')) !!}
  </div>
{!! Form::close() !!}

@endsection
