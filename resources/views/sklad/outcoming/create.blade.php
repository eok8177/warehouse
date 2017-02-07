<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="productSelectLabel">@lang('sklad.products')</h4>
    </div>
    <div class="modal-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>@lang('sklad.title')</th>
            <th>@lang('sklad.measure')</th>
            <th>@lang('sklad.quantity')</th>
            <th>@lang('sklad.averageprice')</th>
          </tr>
        </thead>
        <tr>
          <td>{{$product->title}}</td>
          <td>{{$product->measure}}</td>
          <td>{{$product->quantity}}</td>
          <td>{{$product->sum / $product->quantity}}</td>
        </tr>
      </table>

      <div class="row">
        <div class="modal-header">
          <h4 class="modal-title" id="productSelectLabel">@lang('sklad.outcoming')</h4>
        </div>
        <div class="modal-body">

          <div class="col-md-6">

            {!! Form::open(['route' => ['sklad.outcoming'], 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'outcoming']) !!}

            <div class="form-group">
              {!! Form::label('client_id', Lang::get('sklad.client'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::hidden('client_id', '', ['class' => 'form-control']) !!}
                <span id="client_name"></span>&nbsp;
                <button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#clientSelect" aria-expanded="false" aria-controls="clientSelect">@lang('sklad.select')</button>
              </div>
            </div>

            {!! Form::hidden('product_id', $product->id, ['class' => 'form-control']) !!}

            <div class="form-group">
              {!! Form::label('count', Lang::get('sklad.count'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('count', '', ['class' => 'form-control']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('description', Lang::get('sklad.description'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('description', '', ['class' => 'form-control']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::submit(Lang::get('sklad.save')) !!}
            </div>
            {!! Form::close() !!}

          </div>
          <div class="col-md-6">

            {!! Form::open(['route' => ['sklad.client.store'], 'method' => 'POST', 'class' => 'collapse form-inline', 'id' => 'clientSelect']) !!}
            <h4>@lang('sklad.selectclient')</h4>

            <ul id="clientsList">
              @foreach($clients as $client)
              <li><a href="#" data-id="{{$client->id}}">{{$client->title}}</a></li>
              @endforeach
            </ul>

            <h4>@lang('sklad.addnew')</h4>
            <div class="form-group">
              {!! Form::label('title', Lang::get('sklad.title'), ['class' => 'control-label']) !!}
              {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
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
</div>



<style type="text/css">
  #clientsList {
    max-height: 600px;
    overflow-y: auto;
  }
</style>

<script type="text/javascript">
$(function () {
  $('#clientsList').on('click' , 'a', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var title = $(this).text();
    $('#client_name').text(title);
    $('#client_id').val(id);
    $('#clientSelect').removeClass('in');
  });

  var formAddItem = $("#clientSelect");
  var listItems = $("#clientsList");

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
