<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="incomingLabel">@lang('sklad.incoming')</h4>
    </div>

    <div class="row">
      <div class="modal-body">

        <div class="col-md-6">

          {!! Form::open(['route' => ['sklad.incoming'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}

          {!! Form::hidden('invoice_id', $invoice->id) !!}

          <div class="form-group">
            {!! Form::label('title', Lang::get('sklad.title'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::hidden('product_id', '', ['class' => 'form-control', 'id' => 'product_id']) !!}
              <span id="product_name"></span>&nbsp;
              <button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#productSelect" aria-expanded="false" aria-controls="productSelect">@lang('sklad.select')</button>
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('count', Lang::get('sklad.quantity'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('count', '', ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('price', Lang::get('sklad.price'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('price', '', ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::submit(Lang::get('sklad.save')) !!}
          </div>
          {!! Form::close() !!}

        </div>

        <div class="col-md-6">

          {!! Form::open(['route' => ['sklad.product.store'], 'method' => 'POST', 'class' => 'collapse form-horizontal', 'id' => 'productSelect']) !!}
          <h4>@lang('sklad.selectproduct')</h4>

          <ul id="productsList">
            @foreach($products as $product)
            <li><a href="#" data-id="{{$product->id}}">{{$product->title}} /({{$product->measure}}) / ({{number_format($product->sum / $product->quantity, 2)}}грн)</a></li>
            @endforeach
          </ul>

          <h4>@lang('sklad.addnew')</h4>
          <div class="form-group">
            {!! Form::label('title', Lang::get('sklad.title'), ['class' => 'control-label col-md-6']) !!}
            <div class="col-md-6">
              {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('measure', Lang::get('sklad.measure'), ['class' => 'control-label col-md-6']) !!}
            <div class="col-md-6">
              {!! Form::text('measure', '', ['class' => 'form-control', 'autofocus']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::submit(Lang::get('sklad.save')) !!}
          </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div><!-- row -->
  </div>
</div>




<style type="text/css">
  #productsList {
    max-height: 600px;
    overflow-y: auto;
  }
</style>

<script type="text/javascript">
$(function () {
  $('#productsList').on('click' , 'a', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var title = $(this).text();
    $('#product_name').text(title);
    $('#product_id').val(id);
    $('#productSelect').removeClass('in');
  });

  var formAddItem = $("#productSelect");
  var listItems = $("#productsList");

  formAddItem.submit(function(e) {
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      dataType: 'json',
      success: function(data)
      {
        listItems.append('<li><a href="#" data-id="'+data.id+'">'+data.title+'</a></li>');
      },
      error: function(data)
      {
        formAddItem.append("<p>"+$.parseJSON(data.responseText).title[0]);
      }
    });
    e.preventDefault();
  });

});
</script>
