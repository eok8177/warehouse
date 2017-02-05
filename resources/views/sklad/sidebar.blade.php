<ul class="nav side-nav">
  <li><a href="{{ route('sklad.invoice.index') }}">@lang('sklad.invoices')</a></li>
  <li><a href="{{ route('sklad.product.index') }}">@lang('sklad.products')</a></li>

  <h4 class="page-header">@lang('sklad.reports')</h4>
<li><a href="{{ route('sklad.report.index') }}">@lang('sklad.report')</a></li>


  <h4 class="page-header">@lang('sklad.catalogs')</h4>
  <li><a href="{{ route('sklad.bill.index') }}">@lang('sklad.bills')</a></li>
  <li><a href="{{ route('sklad.supplier.index') }}">@lang('sklad.suppliers')</a></li>
  <li><a href="{{ route('sklad.client.index') }}">@lang('sklad.clients')</a></li>
</ul>