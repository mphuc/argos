@extends('layouts.super-admin')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">@include('sections.ctrl_button')
            <h4 class="page-title" style="min-width: max-content"> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/cc-picker/jquery.ccpicker.css') }}">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css'>
    <style>
        legend {
            display: inline-block;
            padding: 0;
            margin-left: 20px;
            margin-bottom: 0px;
            font-size: 15px;
            line-height: inherit;
            font-family: var(--font-primary);
            font-weight: 400;
            border-bottom: none;
            width: max-content;
            padding-right: 20px;
            color: #333;
        }

        fieldset {
            border: 1px solid #DBD2D2;
            padding: 10px;
            height: 100%;
        }

        .btn-reset {
            background: #C0CDD3 !important;
            margin-right: 10px;
        }

        .row {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(270px, 1fr));
            row-gap: 20px;
            align-items: stretch !important;
        }

        @media only screen and (max-width : 1240px) {
            .row {
                grid-template-columns: repeat(2, minmax(270px, 1fr));
            }
        }

        @media only screen and (max-width : 1040px) {
            .row {
                grid-template-columns: repeat(1, minmax(270px, 1fr));
            }
        }

        .row .col-md-4 {
            width: 100%;
            height: 100% !important;
        }

        fieldset .form-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 5px;
            width: 100%;
            flex-grow: 1;
        }

        fieldset .form-group label,
        fieldset tr td {
            min-width: max-content;
            margin-right: 5px;
            vertical-align: middle;
        }

        td:nth-child(1) {
            display: flex;
            align-items: center;
            padding: 15px 0px;
        }

        td:nth-child(3) {
            padding-left: 5px;
        }

        fieldset table td label {
            color: #000000 !important;
            font-family: "Roboto", sans-serif !important;
            font-size: 15px !important;
            font-weight: 500;
        }

        fieldset table .required:after {
            content: " *";
            color: red;
        }

        fieldset .form-group input,
        fieldset .form-group textarea {
            margin-left: auto;
        }

        .input-group-btn .flag-icon {
            width: 17px;
            height: 14px;
        }

        .input-group-btn .btn {
            padding: 6px 8px !important;
            background-color: white;
            border: 1px solid #CCCCD1;
        }

        .phonecode-select {
            max-height: 300px;
            overflow: auto;
        }

        .cc-picker {
            padding: 6px 8px !important;
            background-color: white;
            border: 1px solid #CCCCD1;
            display: flex;
            width: 100px;
            align-items: center;
            border-radius: 3px
        }

        .datepicker td:nth-child(1),
        .category-table td:nth-child(1) {
            display: table-cell;
        }

        .my-custom-scrollbar {
            position: relative;
            max-height: 200px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .category-table {
            max-width: 560px !important;
        }

    </style>
@endpush

@section('content')

    <div class="">
        <div class="col-xs-12">

            <div class="panel-4">
                <div class="panel-heading">
                    <h2>@lang('app.add') @lang('app.company')</h2>
                </div>

                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id' => 'createCompany', 'class' => 'ajax-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-body" style="margin-top: 40px">

                            <div class="row">

                                <div class="col-md-4">
                                    <fieldset>
                                        <legend>Identifications</legend>
                                        <table>
                                            <tr>
                                                <td><label for="company_name"
                                                        class="required">@lang('app.name_ucfirst')</label></td>
                                                <td>
                                                    <input type="text" class="form-control" id="company_name"
                                                        name="company_name" value="">
                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="legal_form"
                                                        class="required">@lang('app.legalForm')</label></td>
                                                <td><select name="legal_form" id="legal_form" class="form-control select2">
                                                        <option value="" disabled>@lang('app.legalForm')</option>
                                                        @foreach ($tla as $l)
                                                            @if ($l->type == 'legal_form')
                                                                <option value=" {{ $l->name }} ">
                                                                    {{ $l->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select></td>
                                                <td>
                                                    <a href="javascript:;" class="text-info plus-form">
                                                        <img src="{{ asset('img/plus.png') }}" data-type="legal_form" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="address" class="required">@lang('app.address')</label>
                                                </td>
                                                <td><textarea class="form-control" name="address" id="address"
                                                        style="width:100%" rows="2"></textarea></td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="country" class="required">@lang('app.country')</label>
                                                </td>
                                                <td>
                                                    <select name="country" id="country" class="form-control select2">
                                                        @foreach ($countries as $country)
                                                            <option value=" {{ $country->name }} ">
                                                                {{ ucfirst(strtolower($country->name)) }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="city" class="required">@lang('app.cp')</label>
                                                </td>
                                                <td>
                                                    <select name="city" id="city" class="form-control select2">
                                                        <option value="" disabled>@lang('app.cp')</option>
                                                        @foreach ($tla as $t)
                                                            @if ($t->type == 'city')
                                                                <option value=" {{ $t->name }} ">
                                                                    {{ $t->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" class="text-info plus-form">
                                                        <img src="{{ asset('img/plus.png') }}" alt="" data-type="city"> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="activity_sector" class="">Secteur
                                                        d'activité</label>
                                                </td>
                                                <td>
                                                    <select name="activity_sector" id="activity_sector"
                                                        class="form-control select2">
                                                        <option value="" disabled>Secteur
                                                            d'activité</option>
                                                        @foreach ($tla as $a)
                                                            @if ($a->type == 'activity_sector')
                                                                <option value=" {{ $a->name }} ">
                                                                    {{ $a->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                </td>
                                                <td>
                                                    <a href="javascript:;" class="text-info plus-form">
                                                        <img src="{{ asset('img/plus.png') }}" alt="" data-type="activity_sector">
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-xs-12 text-center">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 250px; height: 80px;">

                                                    <img src="{{ $global->logo_url }}" alt="" />
                                                </div>
                                                <a href="#!" class="invisible">
                                                    <img src="{{ asset('img/plus.png') }}" alt="">
                                                </a>
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                    style="width: 250px; height: 80px;">
                                                </div>
                                                <div>
                                                    <span class="btn btn-primary btn-file btn-sm rounded-pill "
                                                        style="padding: 0px 12px !important">
                                                        <span class="fileinput-new "> @lang('app.selectImage') </span>
                                                        <span class="fileinput-exists"> @lang('app.change') </span>
                                                        <input type="file" name="logo" id="logo">
                                                    </span>
                                                    <a href="javascript:;"
                                                        class="btn btn-danger btn-sm fileinput-exists rounded-pill "
                                                        data-dismiss="fileinput" style="padding: 0px 12px !important">
                                                        @lang('app.remove') </a>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset>
                                        <legend>Coordonées </legend>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label for="tel" class="required">Tel</label>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <input type="text" name="company_phone" id="company_phone"
                                                            class="form-control phone-input ccpicker" aria-label="...">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="mobile" class="required">Mobile</label>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <input type="text" name="mobile" id="mobile"
                                                            class="form-control phone-input ccpicker" aria-label="...">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label for="company_email" class="required">Email</label>
                                                </td>
                                                <td>
                                                    <input type="email" id="company_email" name="company_email" class="form-control">

                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="devise" class="required">Devise</label>
                                                </td>
                                                <td>
                                                    <select name="devise" id="devise" class="form-control select2">
                                                        @forelse($currencies as $currency)
                                                            <option @if ($currency->id == $global->currency_id) selected
                                                                @endif value="{{ $currency->id }}">
                                                                {{ $currency->currency_name }} -
                                                                ({{ $currency->currency_symbol }})
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>

                                                </td>
                                                <td>
                                                    <a href=" {{ route('super-admin.currency.create') }} "
                                                        style="background: none">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="language" class="required">Langue</label>
                                                </td>
                                                <td>
                                                    <select name="language" id="language" class="form-control select2">
                                                        <option @if ($global->locale == 'en') selected @endif value="en">
                                                            English
                                                        </option>
                                                        @foreach ($languageSettings as $language)
                                                            <option value="{{ $language->language_code }}"
                                                                @if ($global->locale == $language->language_code) selected @endif>
                                                                {{ $language->language_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href=" {{ route('super-admin.language-settings.create') }} "
                                                        style="background: none">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="siret" class="">N°Siret</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="siret" name="siret"
                                                        value="">

                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="tva_intrat" class="">N°TVA intrat</label>
                                                </td>
                                                <td>
                                                    <select name="tva_intrat" id="tva_intrat" class="form-control select2">
                                                        <option value="" disabled>N°TVA intrat</option>
                                                        @foreach ($tla as $t)
                                                            @if ($t->type == 'tva_intrat')
                                                                <option value=" {{ $t->name }} ">
                                                                    {{ $t->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" class="text-info plus-form">
                                                        <img src="{{ asset('img/plus.png') }}" alt="" data-type="tva_intrat"> </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="description" class="">Description</label>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="description" id="description"
                                                        style="width:100%" rows="2"></textarea>
                                                </td>
                                                <td>
                                                    <a href="#!" class="invisible">
                                                        <img src="{{ asset('img/plus.png') }}" alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset>
                                        <legend>Administrateur</legend>
                                        <div class="d-flex align-items-center">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <label for="admin_name" class="required">Nom de
                                                            l'Administrateur</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="admin_name"
                                                            name="admin_name" value="">
                                                    </td>
                                                    <td>
                                                        <a href="#!" class="invisible">
                                                            <img src="{{ asset('img/plus.png') }}" alt="">
                                                        </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label for="email" class="required">Login/Email</label>
                                                    </td>
                                                    <td>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            value="">
                                                    </td>
                                                    <td>
                                                        <a href="#!" class="invisible">
                                                            <img src="{{ asset('img/plus.png') }}" alt="">
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="password" class="required">Mot de passe</label>
                                                    </td>
                                                    <td>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" value="">

                                                    </td>
                                                    <td>
                                                        <a href="#!" class="invisible">
                                                            <img src="{{ asset('img/plus.png') }}" alt="">
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td></td>
                                                    <td>
                                                        <button type="button" id="send_notification"
                                                            class="btn btn-primary btn-sm"
                                                            style="border-radius: 100px">Envoyer Notification</button>
                                                    </td>
                                                </tr>
                                            </table>

                                            {{-- <div> --}}
                                            {{-- <img src="{{ asset('img/logo-placeholder.png') }}" alt=""> --}}
                                            {{-- </div> --}}

                                        </div>


                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions" style="margin-top: 20px">
                            <button type="submit" id="save-form" class="btn btn-success"> Enregistrer</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .row -->

    <div class="modal fade bs-modal-md in" id="addModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
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

@endsection

@push('footer-script')

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/cc-picker/jquery.ccpicker.js') }}"></script>
    <script>
        $(".select2").select2({
            formatNoMatches: function() {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        $('#save-form').click(function() {

            $.easyAjax({
                url: '{{ route('super-admin.companies.store') }}',
                container: '#createCompany',
                type: "POST",
                redirect: true,
                file: true,
                error: function (response) {
                    $("input").css("border-color", "#ccc")
                    $("input").attr("title", ``)
                    $("textarea").css("border-color", "#ccc")
                    $("textarea").attr("title", ``)
                    $("select").css("border-color", "#ccc")
                    $("select").attr("title", ``)
                    let obj = response.responseJSON.errors
                    for (const property in obj) {
                        $("#"+property).css("border-color", "#ef1f1f")
                        $("#"+property).attr("title", `${obj[property]}`)
                    }
                },
            });
        });

        $(".ccpicker").CcPicker({
            dataUrl: "{{ asset('data.json') }}"
        });

        $(".ccpicker").CcPicker("setCountryByCode", "fr");

        $('.phonecode-item').click(function(event) {
            event.preventDefault();
            var target = $(event.target)[0];

            $('#' + target.dataset.input).val("+" + target.dataset.phonecode)
            $('#' + target.dataset.bindFlag).attr('class', "flag-icon " + target.dataset.flag)
        })

        $('.plus-form').click(function() {
            let target = $(event.target)[0];
            const field = $('#' + target.dataset.type)
            const url = '{{ route('super-admin.tla.create') }}/' + target.dataset.type;
            $('#modelHeading').html('...');
            $.ajaxModal('#addModal', url);
        })
    </script>

@endpush
