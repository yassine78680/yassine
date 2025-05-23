@extends('layouts.back-end.app')

@section('title', translate('currency'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
                {{translate('system_Setup')}}
            </h2>
        </div>
        @include('admin-views.business-settings.system-settings-inline-menu')
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 d-flex align-items-center gap-2">
                    <img width="20 " src="{{dynamicAsset(path: 'public/assets/back-end/img/currency-1.png')}}" alt="">
                    {{translate('default-currency_setup')}}
                </h5>
            </div>
            <div class="card-body">
                <form class="form-inline_ text-start" action="{{route('admin.currency.system-currency-update')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="currency_id" class="title-color">{{translate('currency')}}</label>
                        <select class="form-control js-select2-custom" name="currency_id">
                            @foreach ($currencies->where('status', 1) as $key => $currency)
                                <option value="{{ $currency->id }}" {{$default['value'] == $currency->id?'selected':''}} >
                                    {{ $currency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end flex-wrap mt-3">
                        <button type="submit" class="btn btn--primary px-5">{{translate('save')}}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0 d-flex align-items-center gap-2">
                    <img width="18" src="{{dynamicAsset(path: 'public/assets/back-end/img/currency-1.png')}}" alt="">
                    {{translate('add_currency')}}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.currency.store')}}" method="post">
                    @csrf
                    <div class="">
                        <div class="row">
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <label for="name"
                                               class="title-color mb-0">{{translate('currency_name')}}</label>
                                        <i class="tio-info-outined" data-toggle="tooltip"
                                           title="{{translate('add_the_name_of_the_currency_you_want_to_add')}}"></i>
                                    </div>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="{{translate('ex'.':'.translate('United_States_Dollar'))}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <label for="symbol"
                                               class="title-color mb-0">{{translate('currency_symbol')}}</label>
                                        <i class="tio-info-outined" data-toggle="tooltip"
                                           title="{{translate('add_the_symbol_of_the_currency_you_want_to_add')}}"></i>
                                    </div>
                                    <input type="text" name="symbol" class="form-control" id="symbol"
                                           placeholder="{{translate('ex').':'.'$'}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <label for="symbol"
                                               class="title-color mb-0">{{translate('currency_code')}}</label>
                                        <i class="tio-info-outined" data-toggle="tooltip"
                                           title="{{translate('add_the_code_of_the_currency_you_want_to_add')}}"></i>
                                    </div>
                                    <input type="text" name="code" class="form-control" id="code"
                                           placeholder="{{translate('ex').':'.'USD'}}" required>
                                </div>
                            </div>
                            @if($currencyModel['value']=='multi_currency')
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <label for="exchange_rate"
                                                   class="title-color mb-0">{{translate('exchange_rate')}}</label>
                                            <i class="tio-info-outined" data-toggle="tooltip"
                                               title="{{translate('based_on_your_region_set_the_exchange_rate_of_the_currency_you_want_to_add')}}"></i>
                                        </div>
                                        <input type="number" min="0" max="1000000" name="exchange_rate"
                                               step="0.00000001" class="form-control" id="exchange_rate"
                                               placeholder="{{translate('ex').':'.'120'}}" required>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                                    <button type="submit" id="add"
                                            class="btn btn--primary px-5">{{translate('submit')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mt-4">
                    <div class="table-responsive">
                        <table
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('currency_name')}}</th>
                                <th>{{translate('currency_symbol')}}</th>
                                <th>{{translate('currency_code')}}</th>
                                @if($currencyModel['value']=='multi_currency')
                                    <th>{{translate('exchange_rate')}}
                                        ({{'1'.' '. getCurrencyCode(type: 'default').' '.'='.'?' }})
                                    </th>
                                @endif
                                <th>{{translate('status')}}</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($currencies as $key =>$currency)
                                <tr>
                                    <td>{{$currencies->firstitem()+ $key }}</td>
                                    <td>{{$currency->name}}</td>
                                    <td>{{$currency->symbol}}</td>
                                    <td>{{$currency->code}}</td>
                                    @if($currencyModel['value']=='multi_currency')
                                        <td>{{$currency->exchange_rate}}</td>
                                    @endif
                                    <td>
                                        @if($default['value'] != $currency->id)
                                            @if(($currency->status == 0) || ($currency->status == 1 && ($digitalPaymentStatus ? $currency->must_required_for_gateway != 1 : 1)))
                                                @include("admin-views.currency._status-button-partial")
                                            @else
                                                <label class="switcher" for="currency-status{{ $currency['id'] }}" data-toggle="modal" data-target="#currency-modal{{ $currency['id'] }}">
                                                    <input type="checkbox" class="switcher_input" disabled
                                                           id="currency-status{{$currency['id']}}" name="status" value="1"
                                                           {{$currency->status?'checked':''}}
                                                           data-modal-id = "toggle-status-modal"
                                                           data-toggle-id = "currency-status{{$currency['id']}}"
                                                           data-on-image = "currency-on.png"
                                                           data-off-image = "currency-off.png"
                                                           data-on-title = "{{translate('Want_to_Turn_ON_Currency_Status').'?'}}"
                                                           data-off-title = "{{translate('Want_to_Turn_OFF_Currency_Status').'?'}}"
                                                           data-on-message = "<p>{{translate('if_enabled_this_currency_will_be_available_throughout_the_entire_system')}}</p>"
                                                           data-off-message = "<p>{{translate('if_disabled_this_currency_will_be_hidden_from_the_entire_system')}}</p>">
                                                    <span class="switcher_control"></span>
                                                </label>
                                            @endif
                                        @else
                                            <label class="badge badge-primary-light">{{translate('default')}}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-10 justify-content-center">
                                            @if($currency->code != 'USD')
                                                <a title="{{translate('edit')}}"
                                                   type="button" class="btn btn-outline--primary btn-sm btn-xs edit"
                                                   href="{{route('admin.currency.update',[$currency->id])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a title="{{translate('delete')}}"
                                                   type="button" class="d-flex align-items-center btn btn-outline-danger btn-sm btn-xs {{$default['value'] == $currency['id'] ? 'default-currency-delete-alert' : 'delete-data-without-form'}}"
                                                   data-action="{{route('admin.currency.delete')}}"
                                                   data-id="{{$currency->id}}"
                                                   data-from="currency"
                                                >
                                                    <i class="tio-delete"></i>
                                                </a>
                                            @else
                                                <button title="{{translate('edit')}}"
                                                        class="btn btn-outline--primary btn-sm btn-xs edit" disabled>
                                                    <i class="tio-edit"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @foreach($currencies as $key => $currency)
                        @if(!(($currency->status == 0 && $currency->total_supported_gateway > 0) || ($currency->status == 1 && $currency->must_required_for_gateway != 1)))
                        <div class="modal fade" id="currency-modal{{ $currency['id'] }}" tabindex="-1" aria-labelledby="toggle-modal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                                        <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close">
                                            <i class="tio-clear"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body px-4 px-sm-5 pt-0">
                                        <div class="d-flex flex-column align-items-center text-center gap-2 mb-2">
                                            <div class="toggle-modal-img-box d-flex flex-column justify-content-center align-items-center mb-3 position-relative">
                                                @if($currency->status)
                                                    <img src="{{ getStorageImages(path: null, type: 'banner', source: asset('public/assets/back-end/img/modal/currency-off.png')) }}" class="status-icon"  alt="" width="80"/>
                                                @else
                                                    <img src="{{ getStorageImages(path: null, type: 'banner', source: asset('public/assets/back-end/img/modal/currency-on.png')) }}" class="status-icon"  alt="" width="80"/>
                                                @endif
                                                <img src="" alt="" />
                                            </div>
                                            <h5 class="modal-title">
                                                {{ translate('Are_you_sure') }}, {{ translate('want_to_turn_'. ($currency->status == 1 ? 'Off' : 'ON') .'_currency_status') }}?
                                            </h5>
                                            <div class="text-center">
                                                {{ translate('If_you_enable_this_currency_please_check_in_payment_gateway_settings_that_gateway_support_this_currency_or_not') }}!
                                            </div>
                                            <div class="text-center py-3">
                                                <a class="text-underline font-weight-bold" href="{{ $paymentGatewayPublishedStatus && !empty($paymentGatewayUrl) ? $paymentGatewayUrl : route('admin.business-settings.payment-method.index') }}">
                                                    {{ translate('Go_to_payment_gateway_settings') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center gap-3 mt-3">
                                            <button type="button" class="btn btn--primary min-w-120" data-dismiss="modal">
                                                {{ translate('ok') }}
                                            </button>
                                            <button type="button" class="btn btn-danger-light min-w-120" data-dismiss="modal">
                                                {{ translate('cancel') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            {{$currencies->links()}}
                        </div>
                    </div>
                    @if(count($currencies)==0)
                        @include('layouts.back-end._empty-state',['text'=>'no_currency_found'],['image'=>'default'])
                    @endif
                </div>
            </div>
        </div>
    </div>
    <span id="get-currency-warning-message" data-warning="{{translate('default_currency_can_not_be_deleted').'!'.translate('to_delete_change_the_default_currency_first').'.!'}}"></span>
    <span id="get-delete-currency-message" data-success="{{translate('currency_removed_successfully').'!'}}" data-warning="{{translate('this_Currency_cannot_be_removed_due_to_payment_gateway_dependency').'!'}}"></span>
@endsection

@push('script')
    <script>
        'use strict';
        $('.default-currency-delete-alert').on('click',function () {
            toastr.warning($('#get-currency-warning-message').data('warning'));
        })
    </script>
@endpush
