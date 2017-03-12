@extends('sklad.layouts.default')

@section('content')
<h3 class="page-header">@lang('sklad.product'): {{$product->title}}</h3>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.action')</th>
      <th>@lang('sklad.title')</th>
      <th>@lang('sklad.measure')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.sum')</th>
    </tr>
  </thead>
    <tr>
      <td>
        <a href="{{ route('sklad.product.edit', ['id'=>$product->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('sklad.edit')"></a>
        @if ($product->quantity > 0)
        <a href="{{ route('sklad.outcoming.create', ['id'=>$product->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('sklad.out')"></a>
        @endif
      </td>
      <td>{{$product->title}}</td>
      <td>{{$product->measure}}</td>
      <td>{{$product->quantity}}</td>
      <td>{{$product->sum}}</td>
    </tr>
</table>

<h3 class="page-header">@lang('sklad.incoming')</h3>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.invoice')</th>
      <th>@lang('sklad.quantity')</th>
      <th>@lang('sklad.price')</th>
      <th>@lang('sklad.sum')</th>
    </tr>
  </thead>
  @foreach($product->incoming as $incoming)
    <tr>
      <td>{{$incoming->created_at}}</td>
      <td>{{$incoming->invoice->title}}</td>
      <td>{{$incoming->count}} {{$product->measure}}</td>
      <td>{{$incoming->price}}</td>
      <td>{{$incoming->price * $incoming->count}}</td>
    </tr>
  @endforeach
</table>

<h3 class="page-header">@lang('sklad.outcoming')</h3>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('sklad.date')</th>
      <th>@lang('sklad.client')</th>
      <th>@lang('sklad.count')</th>
      <th>@lang('sklad.sum')</th>
      <th>@lang('sklad.action')</th>
    </tr>
  </thead>
  @foreach($product->outcoming as $outcoming)
    <tr>
      <td title="created: {{$outcoming->created_at}}  updated: {{$outcoming->updated_at}}" class="initialism">
        {{$outcoming->date}}
      </td>
      <td>{{$outcoming->client->title}}</td>
      <td>{{$outcoming->count}} {{$product->measure}}</td>
      <td>{{$outcoming->sum}}</td>
      <td>
        <a href="{{ route('sklad.outcoming.edit', ['id'=>$outcoming->id]) }}" class="ajax btn fa fa-pencil" data-toggle="modal" data-target="#outcoming"></a>
        <a href="{{ route('sklad.outcoming.destroy', ['id'=>$outcoming->id]) }}" class="btn fa fa-trash-o delete" data-toggle="tooltip" data-placement="top" title="@lang('sklad.delete')"></a>
      </td>
    </tr>
  @endforeach
    <tr>
      <td colspan="2"></td>
      <td>{{$product->outcoming->sum('count')}}</td>
      <td>{{$product->outcoming->sum('sum')}}</td>
    </tr>
</table>

<!-- Modal -->
<div class="modal fade" id="outcoming" tabindex="-1" role="dialog" aria-labelledby="outcomingLabel"></div>
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