@extends('apteka.layouts.default')

@section('content')
<h3 class="page-header">@lang('apteka.product'): {{$product->title}}</h3>

<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.action')</th>
      <th>@lang('apteka.title')</th>
      <th>@lang('apteka.measure')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.sum')</th>
    </tr>
  </thead>
    <tr>
      <td>
        <a href="{{ route('apteka.product.edit', ['id'=>$product->id]) }}" class="btn fa fa-pencil" data-toggle="tooltip" data-placement="top" title="@lang('apteka.edit')"></a>
        @if ($product->quantity > 0)
        <a href="{{ route('apteka.outcoming.create', ['id'=>$product->id]) }}" class="ajax btn fa fa-sign-out" data-toggle="modal" data-target="#outcoming" title="@lang('apteka.out')"></a>
        @endif
      </td>
      <td>{{$product->title}}</td>
      <td>{{$product->measure}}</td>
      <td>{{$product->quantity}}</td>
      <td>{{$product->sum}}</td>
    </tr>
</table>

<h3 class="page-header">@lang('apteka.incoming')</h3>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.date')</th>
      <th>@lang('apteka.invoice')</th>
      <th>@lang('apteka.quantity')</th>
      <th>@lang('apteka.price')</th>
      <th>@lang('apteka.sum')</th>
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

<h3 class="page-header">@lang('apteka.outcoming')</h3>
<table class="table table-hover">
  <thead>
    <tr>
      <th>@lang('apteka.date')</th>
      <th>@lang('apteka.client')</th>
      <th>@lang('apteka.count')</th>
      <th>@lang('apteka.sum')</th>
      <th>@lang('apteka.action')</th>
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
        <a href="{{ route('apteka.outcoming.edit', ['id'=>$outcoming->id]) }}" class="ajax btn fa fa-pencil" data-toggle="modal" data-target="#outcoming"></a>
        <a href="{{ route('apteka.outcoming.destroy', ['id'=>$outcoming->id]) }}" class="btn fa fa-trash-o delete" data-toggle="tooltip" data-placement="top" title="@lang('apteka.delete')"></a>
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