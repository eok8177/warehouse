@extends('backend.layouts.default')

@section('content')
<h1 class="page-header">@lang('messages.lpz')</h1>

<a href="{{ route('backend.lpz.create') }}" class="btn fa fa-plus"> @lang('messages.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>Action</th>
      <th>@lang('messages.name')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('backend.lpz.show', ['id'=>$item->id]) }}" class="btn fa fa-eye"></a>
        <a href="{{ route('backend.lpz.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil"></a>
        <!-- <a href="{{ route('backend.lpz.destroy', ['id'=>$item->id]) }}" class="btn fa fa-trash-o delete"></a> -->
      </td>
      <td>{{$item->name}}</td>
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
      if (!confirm('Are you sure you want to delete?')) return;
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