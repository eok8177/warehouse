<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="incomingLabel">@lang('apteka.incoming')</h4>
    </div>

    <div class="row">
      <div class="modal-body">

        <div class="col-md-6">

          {!! Form::open(['route' => ['apteka.incoming'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}

          {!! Form::hidden('invoice_id', $invoice->id) !!}

          <div class="form-group">
            {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::hidden('product_id', '', ['class' => 'form-control', 'id' => 'product_id']) !!}
              <span id="product_name"></span>&nbsp;
              <button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#productSelect" aria-expanded="false" aria-controls="productSelect">@lang('apteka.select')</button>
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('count', Lang::get('apteka.quantity'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('count', '', ['class' => 'form-control', 'onchange' => "this.value = this.value.replace(/,/g, '.')"]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('price', Lang::get('apteka.price'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('price', '', ['class' => 'form-control', 'onchange' => "this.value = this.value.replace(/,/g, '.')"]) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('cert', Lang::get('apteka.cert'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('cert', '', ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('serial', Lang::get('apteka.serial'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('serial', '', ['class' => 'form-control']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('expire', Lang::get('apteka.expire'), ['class' => 'col-md-6 control-label']) !!}
            <div class="col-md-6">
              {!! Form::text('expire', '', ['class' => 'form-control', 'id' => 'datepicker']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::submit(Lang::get('apteka.save')) !!}
          </div>
          {!! Form::close() !!}

        </div>

        <div class="col-md-6">

          {!! Form::open(['route' => ['apteka.product.store'], 'method' => 'POST', 'class' => 'collapse form-horizontal', 'id' => 'productSelect']) !!}
          <h4>@lang('apteka.selectproduct')</h4>

          <ul id="productsList">
            @foreach($products as $product)
            <li><a href="#" data-id="{{$product->id}}">{{$product->title}} /({{$product->measure}}) / ({{ ($product->quantity > 0) ? number_format($product->sum/$product->quantity, 2) : '0'}}грн)</a></li>
            @endforeach
          </ul>

          <h4>@lang('apteka.addnew')</h4>
          <div class="form-group">
            {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'control-label col-md-6']) !!}
            <div class="col-md-6">
              {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('measure', Lang::get('apteka.measure'), ['class' => 'control-label col-md-6']) !!}
            <div class="col-md-6">
              {!! Form::text('measure', '', ['class' => 'form-control', 'autofocus']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::submit(Lang::get('apteka.save')) !!}
          </div>
          {!! Form::close() !!}

        </div>
      </div>
    </div><!-- row -->
  </div>
</div>




<style type="text/css">
  #productsList {
    max-height: 320px;
    overflow-y: auto;
  }
</style>

<script type="text/javascript">
$(function () {
  $.datepicker.setDefaults($.datepicker.regional[ "uk" ]);
  $( "#datepicker" ).datepicker({
      dateFormat: "yy-mm-dd",
    });

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
        $('#product_name').text(data.title);
        $('#product_id').val(data.id);
        $('#productSelect').removeClass('in');
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
