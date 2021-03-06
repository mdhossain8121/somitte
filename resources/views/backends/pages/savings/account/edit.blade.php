@extends('backends.pages.main')
@section('main-body')
{{-- @include('backends.partials.messages') --}}
<!-- Tooltip Validation card start -->
<div class="card">
    <div class="card-header">
        <h5>Edit Savings Account</h5>
    </div>
    <div class="card-block">
        <form action="{{route('account.update',$savingsAccount->encryptId)}}" method="post" novalidate="">
            @csrf
            @method('patch')
            <div class="form-group row @error('customer_id') has-error @enderror">
                <label class="col-sm-2 col-form-label"> Customer * </label>
                <div class="col-sm-10">
                    <select name="customer_id" class="form-control select2-select" data-placeholder="Select Customer" required>
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{$customer->encryptId}}" @if($customer->id==$savingsAccount->customer_id) selected @endif> {{$customer->name}} :: {{$customer->customer_uid}} </option>
                        @endforeach
                    </select>
                    <span class="messages popover-valid">
                        @error('customer_id')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row @error('savings_scheme_id') has-error @enderror">
                <label class="col-sm-2 col-form-label"> Savings Scheme * </label>
                <div class="col-sm-10">
                    <select name="savings_scheme_id" class="form-control select2-select" data-placeholder="Select Savings Scheme" required>
                        <option value="">Select Savings Scheme</option>
                        @foreach ($savingsSchemes as $savingsScheme)
                            <option late_fee="{{ $savingsScheme->late_fee}}" amount="{{ $savingsScheme->amount}}" profit="{{ $savingsScheme->profit}}" value="{{$savingsScheme->encryptId}}" @if($savingsScheme->id==$savingsAccount->savings_scheme_id) selected @endif> {{$savingsScheme->name}} </option>
                        @endforeach
                    </select>
                    <span class="messages popover-valid">
                        @error('savings_scheme_id')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row @error('deposit_amount') has-error @enderror">
                <label class="col-sm-2 col-form-label">Deposit Amount</label>
                <div class="col-sm-10">
                    <input readonly autocomplete="off" type="text" class="form-control decimalNumber" name="deposit_amount" placeholder="Enter Deposit Amount" value="{{ old('deposit_amount')?:$savingsAccount->deposit_amount }}">
                    <span class="messages popover-valid-inline">
                        @error('deposit_amount')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row @error('profit') has-error @enderror">
                <label class="col-sm-2 col-form-label">Profit (%)</label>
                <div class="col-sm-10">
                    <input readonly autocomplete="off" type="text" class="form-control decimalNumber" name="profit" placeholder="Enter Profit" value="{{ old('profit')?:$savingsAccount->profit }}">
                    <span class="messages popover-valid-inline">
                        @error('profit')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row @error('late_fee') has-error @enderror">
                <label class="col-sm-2 col-form-label">Late Fee</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control wholeNumber" name="late_fee" placeholder="Enter Late Fee" value="{{ old('late_fee')?:$savingsAccount->late_fee }}">
                    <span class="messages popover-valid-inline">
                        @error('late_fee')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row @error('account_no') has-error @enderror">
                <label class="col-sm-2 col-form-label">Account No</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control" name="account_no" placeholder="Enter Account No" value="{{ old('account_no')?:$savingsAccount->account_no }}">
                    <span class="messages popover-valid">
                        @error('account_no')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row  @error('first_deposit_amount') has-error @enderror">
                <label class="col-sm-2 col-form-label">First Deposit Amount</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control decimalNumber" name="first_deposit_amount" placeholder="Enter First Deposit Amount" value="{{ old('first_deposit_amount')?:$savingsAccount->first_deposit_amount }}">
                    <span class="messages popover-valid">
                        @error('first_deposit_amount')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Start Date</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control today-datepicker @error('start_date') form-control-danger @enderror" name="start_date" placeholder="Enter Scheme Start date" value="{{ old('start_date')?:$savingsAccount->start_date}}">
                    <span class="messages popover-valid">
                        @error('start_date')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">End Date</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" class="form-control single-datepicker @error('end_date') form-control-danger @enderror" name="end_date" placeholder="Enter Scheme End date" value="{{old('end_date')?:$savingsAccount->end_date}}">
                    <span class="messages popover-valid">
                        @error('end_date')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Remarks</label>
                <div class="col-sm-10">
                    <textarea rows="5" name="remarks" class="form-control @error('remarks') form-control-danger @enderror" placeholder="Enter Remarks">{{ old('remarks')?:$savingsAccount->remarks }}</textarea>
                    <span class="messages popover-valid">
                        @error('remarks')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"> Active Status </label>
                <div class="col-sm-10">
                    <select name="active_fg" class="form-control">
                        <option value="1" @if($savingsAccount->active_fg==1 && old('active_fg')==1) selected @endif>ACTIVE</option>
                        <option value="0" @if($savingsAccount->active_fg==0 && old('active_fg')==0) selected @endif>INACTIVE</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Tooltip Validation card end -->

<script>
    $(document).ready(function () {

        $(document).on('change','select[name="savings_scheme_id"]',function (params) {
            var schemeId = $(this).val();
            var form = $(this).closest('form');
            elementDepositAmount = form.find('input[name="deposit_amount"]');
            elementLateFee = form.find('input[name="late_fee"]');
            elementProfit = form.find('input[name="profit"]');
            elementDepositAmount.val("");
            if(schemeId){
                var element = $(this).find('option:selected');
                var maxInstallment = element.attr('max-installment');
                elementDepositAmount.val(element.attr('amount'));
                elementProfit.val(element.attr('profit'));
                elementLateFee.val(element.attr('late_fee'));
                elementDepositAmount.attr("readonly", false);
            }else{
                elementDepositAmount.attr("readonly", true);
                elementLateFee.val("");
                elementProfit.val("");
            }
        });

        // $('select[name="savings_scheme_id"]').trigger("change");
    })
</script>

@endsection

