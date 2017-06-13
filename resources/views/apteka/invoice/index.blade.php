@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.invoices')</h1>

<a href="{{ route('apteka.invoice.create') }}" class="btn fa fa-plus"> @lang('apteka.create')</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>@lang('apteka.action')</th>
      <th>@lang('apteka.invoice_title')</th>
      <th>@lang('apteka.supplier')</th>
      <th>@lang('apteka.price')</th>
      <th>@lang('apteka.date')</th>
      <th>@lang('apteka.products')</th>
    </tr>
  </thead>
  @foreach($items as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>
        <a href="{{ route('apteka.invoice.show', ['id'=>$item->id]) }}" class="btn fa fa-eye" data-toggle="tooltip" data-placement="top" title="@lang('apteka.show')"></a>
        <a href="{{ route('apteka.invoice.edit', ['id'=>$item->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('apteka.edit')"></a>
        @if(count($item->products) == 0)<a href="{{ route('apteka.invoice.destroy', ['id'=>$item->id]) }}" class="btn fa fa-trash-o delete" data-toggle="tooltip" data-placement="top" title="@lang('apteka.delete')"></a>@endif
      </td>
      <td>{{$item->title}}</td>
      <td>{{$item->supplier->title}}</td>
      <td>{{$item->products->sum('sum')}}</td>
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