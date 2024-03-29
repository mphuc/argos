@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title">  {{ __($pageTitle) }} #{{ $project->id }} - <span
                        class="font-bold">{{ ucwords($project->project_name) }}</span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.projects.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.menu.invoices')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection
@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<style>
    .dropdown-content {
        width: 250px;
        max-height: 250px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .list-group-item,
    .list-group-item .row{
        display: flex;
        width: 100%;
    }

    .btn-cs-green{
        padding: 6px 0px !important;
    }

    .white-box{
        margin-top: 20px;
    }
</style>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            @include('admin.projects.show_project_menu')
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <x-main-header>
                <x-slot name="title">
                    @lang('app.menu.invoices')
                </x-slot>

                {{-- <x-slot name="btns">
                    <a href="javascript:;" id="show-invoice-modal"
                       class="btn btn-success"><i class="ti-plus"></i> @lang('modules.invoices.addInvoice')</a>
                </x-slot> --}}
            </x-main-header>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            
            <section>
                <div class="sttabs tabs-style-line">
                    <div class="content-wrap">
                        <section id="section-line-3" class="show">
                            <div class="row">
                                <div class="col-xs-12" id="invoices-list-panel">
                                    <div class="white-box panel panel-default">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('app.menu.client')</th>
                                                    <th>N° @lang('app.menu.invoices')</th>
                                                    <th>@lang('app.date')</th>
                                                    <th>@lang('modules.invoices.amount') HT</th>
                                                    <th>@lang('modules.invoices.amount') TVA</th>
                                                    <th>@lang('modules.invoices.amount') TTC</th>
                                                    <th>@lang('modules.clients.balance')</th>
                                                    <th>@lang('app.status')</th>
                                                    {{-- <th>@lang('app.action')</th> --}}
                                                </tr>
                                                </thead>
                                                @forelse($project->clientInvoices as $key=>$invoice)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $invoice->clientdetails->company_name}}</td>
                                                        <td>{{ $invoice->invoice_number}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format($global->date_format)}}</td>
                                                        <td>{{ $invoice->sub_total}}</td>
                                                        <td>{{ $invoice->tva}}</td>
                                                        <td>{{ $invoice->total}}</td>
                                                        <td>{{ $invoice->payment ? $invoice->total - $invoice->payment->sum('amount') : $invoice->total}}</td>
                                                        <td>{{ __('modules.invoices.'.$invoice->status)}}</td>
                                                        {{-- <td>
                                                            <a href="javascript:;" data-id="{{$invoice->id}}" data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary btn-circle edit-invoice-modal"><i class="fa fa-pencil"></i></a>
                                                            <a href="javascript:;" data-id="{{$invoice->id}}" data-toggle="tooltip" data-original-title="Delete" class="btn btn-danger btn-circle delete-invoice"><i class="fa fa-times"></i></a>
                                                        </td> --}}
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9">@lang('messages.noInvoiceFound')</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                                <tbody id="timer-list">
                                            </table>
                                        </div>
                                
                                        {{-- <ul class="list-group" id="invoices-list">
                                            @forelse($project->invoices as $invoice)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-5 col-xs-12">
                                                            {{ $invoice->invoice_number }}
                                                        </div>
                                                        <div class="col-sm-2">
                                                            {{ currency_formatter($invoice->total, $invoice->currency->currency_symbol ?? '€') }}
                                                        </div>
                                                        <div class="col-sm-2 col-xs-12">
                                                            @if ($invoice->credit_note)
                                                                <label class="label label-warning">
                                                                    {{ strtoupper(__('app.credit-note')) }}
                                                                </label>
                                                            @else
                                                                @if ($invoice->status == 'unpaid')
                                                                    <label class="label label-danger">
                                                                        {{ strtoupper($invoice->status) }}
                                                                    </label>
                                                                @elseif ($invoice->status == 'paid')
                                                                    <label class="label label-success">
                                                                        {{ strtoupper($invoice->status) }}
                                                                    </label>
                                                                @elseif ($invoice->status == 'canceled')
                                                                    <label class="label label-danger">
                                                                        {{ strtoupper($invoice->status) }}
                                                                    </label>
                                                                @else
                                                                    <label class="label label-info">
                                                                        {{ strtoupper(__('modules.invoices.partial')) }}
                                                                    </label>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-3 col-xs-12">
                                                            <span class="">{{ $invoice->issue_date->format($global->date_format) }}</span>
                                                            <a href="{{ route('admin.invoices.download', $invoice->id) }}" data-toggle="tooltip" data-original-title="Download" class="btn btn-cs-green btn-circle m-l-10"><i class="fa fa-download"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            @lang('messages.noInvoice')
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul> --}}
                                    </div>
                                </div>

                            </div>
                        </section>

                    </div><!-- /content -->
                </div><!-- /tabs -->
            </section>
        </div>


    </div>
    <!-- .row -->

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-lg in" id="add-invoice-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="taxModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    @lang('app.loading')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn blue">@lang('app.save') @lang('changes')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection
@push('footer-script')
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

<script>
    $('#show-invoice-modal').click(function(){
        var url = '{{ route('admin.invoices.createInvoice', $project->id)}}';
        $('#modelHeading').html('Add Invoice');
        $.ajaxModal('#add-invoice-modal',url);
    })

    $('body').on('click', '.sa-params', function () {
        var id = $(this).data('invoice-id');
        swal({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.confirmation.deleteRecoverInvoice')",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "@lang('messages.deleteConfirmation')",
            cancelButtonText: "@lang('messages.confirmNoArchive')",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "{{ route('admin.invoices.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                    success: function (response) {
                        if (response.status == "success") {
                            $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                            $('#invoices-list-panel ul.list-group').html(response.html);

                        }
                    }
                });
            }
        });
    });
    $('ul.showProjectTabs .projectInvoices').addClass('tab-current');
</script>
@endpush
