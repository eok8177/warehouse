@extends('backend.layouts.default')

@section('content')
<h1 class="page-header">@lang('messages.work')</h1>

{!! Form::open(['route' => ['backend.work.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('lpz_id', Lang::get('messages.lpz'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::select('lpz_id', $lpz, false, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('cat_id', Lang::get('messages.cat'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::select('cat_id', $cat, false, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('invoice', Lang::get('messages.invoice'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('invoice', false, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('summ', Lang::get('messages.summ'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('summ', false, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('description', Lang::get('messages.description'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::textarea('description', false, ['class' => 'form-control']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('messages.save')) !!}
  </div>
{!! Form::close() !!}

@endsection

@section('scripts')
<script>
  $(function () {

  });
</script>
@endsection