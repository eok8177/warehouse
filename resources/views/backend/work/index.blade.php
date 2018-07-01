@extends('backend.layouts.default')

@section('content')
<h4>@lang('messages.work')</h4>

<a href="{{ route('backend.work.create') }}" class="btn fa fa-plus"> @lang('messages.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('messages.date')</th>
      <th>Action</th>
      <th>@lang('messages.description')</th>
      <th>@lang('messages.lpz')</th>
      <th>@lang('messages.category')</th>
      <th>@lang('messages.invoice')</th>
      <th>@lang('messages.summ')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{ $item->created_at->format('d-m-Y') }}</td>
      <td>
        {{-- <a href="{{ route('backend.work.show',    ['id'=>$item->id]) }}" class="btn fa fa-eye"></a> --}}
        <a href="{{ route('backend.work.edit',    ['id'=>$item->id]) }}" class="btn fa fa-pencil"></a>
        <a href="{{ route('backend.work.destroy', ['id'=>$item->id]) }}" class="btn fa fa-trash-o delete"></a>
      </td>
      <td>{{$item->description}}</td>
      <td>{{$item->lpz->name}}</td>
      <td>{{$item->cat->name}}</td>
      <td>{{$item->invoice}}</td>
      <td>{{$item->summ}}</td>
    </tr>
  @endforeach
</table>

{{ $items->links() }}
<a href="#wrapper" class="btn btn-default pull-right"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>


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