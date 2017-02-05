@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">Склад титульная</h1>

<table class="table table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>Action</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
    </tr>
  </thead>
  @foreach($products as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('sklad.product.show', ['id'=>$item->id]) }}" class="btn fa fa-eye"></a>
        <a href="{{ route('sklad.product.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil"></a>
      </td>
      <td>{{$item->title}}</td>
      <td>{{$item->measure}}</td>
      <td>{{$item->quantity}}</td>
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