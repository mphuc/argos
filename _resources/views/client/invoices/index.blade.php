@extends('layouts.client-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title">  {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
            <a href="{{ route('client.invoice-recurring.index') }}" class="btn btn-outline btn-info btn-sm">@lang('app.invoiceRecurring') </a>
            @if ($company_details->count() > 1)
            <div class="col-md-3 pull-right hidden-xs hidden-sm">
                <select class="selectpicker company-switcher margin-right-auto" data-width="fit" name="companies" id="companies">
                    @foreach ($company_details as $company_detail)
                        <option {{ $company_detail->company->id === $global->id ? 'selected' : '' }} value="{{ $company_detail->company->id }}">{{ ucfirst($company_detail->company->company_name) }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <ol class="breadcrumb">
                <li><a href="{{ route('client.dashboard.index') }}">@lang("app.menu.home")</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="invoices-table">
                    <thead>
                    <tr>
                        <th>@lang("app.id")</th>
                        <th>@lang("modules.projects.projectName")</th>
                        <th>@lang("app.invoice") #</th>
                        <th>@lang("modules.invoices.currency")</th>
                        <th>@lang("modules.invoices.amount")</th>
                        <th>@lang("modules.invoices.invoiceDate")</th>
                        <th>@lang("app.status")</th>
                        <th>@lang("app.action")</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- .row -->


@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script>
    $(function() {
        var table = $('#invoices-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ route('client.invoices.create') }}',
            deferRender: true,
            "order": [[ 0, "desc" ]],
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'project_name', name: 'projects.project_name' },
                { data: 'invoice_number', name: 'invoice_number'},
                { data: 'currency_symbol', name: 'currencies.currency_symbol' },
                { data: 'total', name: 'total' },
                { data: 'issue_date', name: 'issue_date' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

    });

</script>
@endpush