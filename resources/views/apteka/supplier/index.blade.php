@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.suppliers')</h1>

<a href="{{ route('apteka.supplier.create') }}" class="btn fa fa-plus"> @lang('apteka.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>Action</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.description')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('apteka.supplier.show', ['id'=>$item->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')"></a>
        <a href="{{ route('apteka.supplier.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('apteka.edit')"></a>
      </td>
      <td>{{$item->title}}</td>
      <td>{{$item->description}}</td>
    </tr>
  @endforeach
</table>


@endsection

@section('scripts')
  <script>
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.delete').on('click', function (e) {
      if (!confirm("@lang('apteka.confirm_delete')")) return false;
    e.preventDefault();
      $.post({
          type: 'DELETE',  // destroy Method
          url: $(this).attr("href")
      }).done(function (data) {
          console.log(data);
          location.reload(true);
      });
    });
  });
</script>
@endsection