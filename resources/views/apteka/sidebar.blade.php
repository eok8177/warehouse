<ul class="nav side-nav">
  <li><a href="{{ route('apteka.invoice.index') }}">@lang('apteka.invoices')</a></li>
  <li><a href="{{ route('apteka.product.index') }}">@lang('apteka.products')</a></li>

  <h4 class="page-header">@lang('apteka.reports')</h4>
<li><a href="{{ route('apteka.report.index') }}">@lang('apteka.report')</a></li>


  <h4 class="page-header">@lang('apteka.catalogs')</h4>
  <li><a href="{{ route('apteka.bill.index') }}">@lang('apteka.bills')</a></li>
  <li><a href="{{ route('apteka.supplier.index') }}">@lang('apteka.suppliers')</a></li>
  <li><a href="{{ route('apteka.client.index') }}">@lang('apteka.clients')</a></li>
</ul>