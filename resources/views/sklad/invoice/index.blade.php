@extends('sklad.layouts.default')

@section('content')
<h1 class="page-header">@lang('sklad.invoices')</h1>

<a href="{{ route('sklad.invoice.create') }}" class="btn fa fa-plus"> @lang('sklad.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>Action</th>
      <th>@lang('sklad.invoice_title')</th>
      <th>@lang('sklad.supplier')</th>
      <th>@lang('sklad.price')</th>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.products')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('sklad.invoice.show', ['id'=>$item->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('sklad.show')"></a>
        <a href="{{ route('sklad.invoice.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('sklad.edit')"></a>
        @if(count($item->products) == 0)<a href="{{ route('sklad.invoice.destroy', ['id'=>$item->id]) }}" class="btn fa fa-trash-o delete" data-toggle="tooltip" data-placement="top" title="@lang('sklad.delete')"></a>@endif
      </td>
      <td>{{$item->title}}</td>
      <td>{{$item->supplier->title}}</td>
      <td>{{$item->price}}</td>
      <td>{{$item->date}}</td>
      <td>{{count($item->products)}}</td>
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