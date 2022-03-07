@extends('layouts.app')

@section('page-title')
<x-main-header>
    <x-slot name="title">
        @lang($pageTitle) 
    </x-slot>
</x-main-header>
@endsection

@push('head-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

    @include('admin.spv.client_header')

    @include('admin.spv.tabs')

    <x-tab-container title="app.menu.contacts">
        <div style="display: grid;">
            
            <x-slot name="btns">
                {{-- <a href="" id="show-add-form" class="btn btn-cs-green"><i class="fa fa-user-plus"></i> @lang('modules.contacts.addContact')</a>  --}}
                <a href="{{route('admin.contact.create')}}" id="" class="btn btn-cs-green"><i class="fa fa-user-plus"></i> @lang('modules.contacts.addContact')</a> 
            </x-slot>

            <div class="col-xs-12">
                {!! Form::open(['id'=>'addContact','class'=>'ajax-form hide','method'=>'POST']) !!}
    
                {{-- {!! Form::hidden('user_id', $client->id) !!} --}}
    
                <div class="form-body">
                    <div class="row m-t-30">
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label>@lang('modules.contacts.contactName')</label>
                                <input type="text" name="contact_name" id="contact_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label>@lang('app.phone')</label>
                                <input id="phone" name="phone" type="tel" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label>@lang('app.email')</label>
                                <input id="email" name="email" type="email" class="form-control" >
                            </div>
                        </div>
                    </div>
    
                </div>
                <div class="form-actions m-t-30">
                    <button type="button" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
                </div>
                {!! Form::close() !!}
    
                <hr>
            </div>
    
            <div class="table-responsive m-t-30">
                <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="contacts-table">
                    <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th>@lang('app.name')</th>
                        <th>@lang('app.phone')</th>
                        <th>@lang('app.email')</th>
                        <th>@lang('app.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Demo Name</td>
                            <td>+3827937289</td>
                            <td>demo@gmail.com</td>
                            <td>
                                <a href="javascript:;" class="btn btn-info btn-circle edit-contact" data-toggle="tooltip" data-contact-id="4" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="javascript:;" class="btn btn-danger btn-circle sa-params" data-toggle="tooltip" data-contact-id="4" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </x-tab-container>


    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="editContactModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection

@push('footer-script')

<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script>
    var table = $('#contacts-table').dataTable({
        responsive: true,
        processing: true,
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.contacts.store')}}',
            container: '#addContact',
            type: "POST",
            data: $('#addContact').serialize(),
            success: function (data) {
                if(data.status == 'success'){
                    $('#addContact').toggleClass('hide', 'show');
                    $('.form-control').val(''); 
                    table._fnDraw();
                }
            }
        })
    });

    $('#show-add-form').click(function () {
        $('#addContact').toggleClass('hide', 'show');
    });


    $('body').on('click', '.sa-params', function(){
        var id = $(this).data('contact-id');
        swal({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.confirmation.recoverContact')",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "@lang('messages.confirmUnsubscribe')",
            cancelButtonText: "@lang('messages.confirmNoArchive')",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "{{ route('admin.contacts.destroy',':id') }}";
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
                            table._fnDraw();
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.edit-contact', function () {
        var id = $(this).data('contact-id');

        var url = '{{ route('admin.spv.edit-contact', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Update Contact');
        $.ajaxModal('#editContactModal',url);

    });


</script>
<script>
    $('ul.showClientTabs .clientContacts').addClass('tab-current');
</script>
@endpush