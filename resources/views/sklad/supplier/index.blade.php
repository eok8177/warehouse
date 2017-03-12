@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.suppliers')</h1>

<a href="{{ route('sklad.supplier.create') }}" class="btn fa fa-plus"> @lang('sklad.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>Action</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.description')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('sklad.supplier.show', ['id'=>$item->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('sklad.show')"></a>
        <a href="{{ route('sklad.supplier.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('sklad.edit')"></a>
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
      if (!confirm("@lang('sklad.confirm_delete')")) return false;
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