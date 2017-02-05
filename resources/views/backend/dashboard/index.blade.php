@extends('backend.layouts.default')

@section('content')
<h3 class="page-header">@lang('messages.work')</h3>

<a href="{{ route('backend.work.create') }}" class="btn fa fa-plus"> @lang('messages.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th style="width: 60px;">id</th>
      <th style="width: 150px;">Action</th>
      <th>@lang('messages.lpz')</th>
      <th>@lang('messages.category')</th>
      <th>@lang('messages.invoice')</th>
      <th>@lang('messages.summ')</th>
      <th>@lang('messages.description')</th>
      <th>@lang('messages.date')</th>
    </tr>
  </thead>
  @foreach($works as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('backend.work.show', ['id'=>$item->id]) }}" class="btn fa fa-eye"></a>
        <a href="{{ route('backend.work.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil"></a>
      </td>
      <td>{{$item->lpz->name}}</td>
      <td>{{$item->cat->name}}</td>
      <td>{{$item->invoice}}</td>
      <td>{{$item->summ}}</td>
      <td>{{$item->description}}</td>
      <td>{{ $item->created_at->format('d-m-Y') }}</td>
    </tr>
  @endforeach
</table>



@endsection

@section('scripts')
<script>
  $(function () {

  });
</script>
@endsection