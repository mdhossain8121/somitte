@extends('backends.pages.main')
@section('main-body')
<!-- Tooltip Validation card start -->
<div class="card">
    <div class="card-header">
        <h5>Create New Loan Account</h5>
    </div>
    <div class="card-block">
        <form action="{{route('account.store')}}" method="post" novalidate="">
            @csrf
            <div class="row">
                <div class="col-md-4 form-group @error('account_no') has-error @enderror">
                    <label class="col-form-label">Account No</label>
                    <input autocomplete="off" type="text" class="form-control" name="account_no" placeholder="Enter Account No" value="{{ old('account_no') }}">
                    <span class="messages popover-valid">
                        @error('account_no')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-4 form-group @error('customer_id') has-error @enderror">
                    <label class="col-form-label"> Customer * </label>
                    <select name="customer_id" class="form-control select2-select" data-placeholder="Select Customer" required>
                        <option value=""> Select Customer </option>
                        @foreach ($customers as $customer)
                            <option value="{{$customer->encryptId}}" @if(!@empty(old('customer_id')) && Crypt::decrypt(old('customer_id')) == $customer->id) selected @endif> {{$customer->name}} :: {{$customer->customer_uid}} </option>
                        @endforeach
                    </select>
                    <span class="messages popover-valid">
                        @error('customer_id')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-4 form-group @error('nominee_id') has-error @enderror">
                    <label class="col-form-label"> Nominee * </label>
                    <select name="nominee_id" class="form-control select2-select" data-placeholder="Select Nominee" required>
                        <option value=""> Select Nominee </option>
                        @foreach ($customers as $nominee)
                            <option value="{{$nominee->encryptId}}" @if(!@empty(old('nominee_id')) && Crypt::decrypt(old('nominee_id')) == $nominee->id) selected @endif> {{$nominee->name}} :: {{$nominee->customer_uid}} </option>
                        @endforeach
                    </select>
                    <span class="messages popover-valid">
                        @error('nominee_id')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>


            <div class="row">
                <div class="col-md-3 form-group @error('loan_scheme_id') has-error @enderror">
                    <label class="col-form-label"> Loan Scheme * </label>
                    <select name="loan_scheme_id" class="form-control select2-select" data-placeholder="Select Loan Scheme" required>
                        <option value="">Select Loan Scheme</option>
                        @foreach ($loanSchemes as  $loanScheme)
                            <option min="{{ $loanScheme->min_amount}}" min="{{ $loanScheme->max_amount}}"  value="{{ $loanScheme->encryptId}}" @if(!@empty(old('loan_scheme_id')) && Crypt::decrypt(old('loan_scheme_id')) ==  $loanScheme->id) selected @endif> {{ $loanScheme->name}} </option>
                        @endforeach
                    </select>
                    <span class="messages popover-valid">
                        @error('loan_scheme_id')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>


                <div class="col-md-3 form-group @error('min_amount') has-error @enderror">
                    <label class="col-form-label">Min Amount</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="min_amount" placeholder="Enter Min Amount" value="{{ old('min_amount') }}">
                    <span class="messages popover-valid">
                        @error('min_amount')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('max_amount') has-error @enderror">
                    <label class="col-form-label">Max Amount</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="max_amount" placeholder="Enter Max Amount" value="{{ old('max_amount') }}">
                    <span class="messages popover-valid">
                        @error('max_amount')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('max_installment') has-error @enderror">
                    <label class="col-form-label">Max Installment</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="max_installment" placeholder="Enter Max Installment" value="{{ old('max_installment') }}">
                    <span class="messages popover-valid">
                        @error('max_installment')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 form-group  @error('loan_amount') has-error @enderror">
                    <label class="col-form-label">Loan Amount</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="loan_amount" placeholder="Enter Loan Amount" value="{{ old('loan_amount') }}">
                    <span class="messages popover-valid">
                        @error('loan_amount')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('rate') has-error @enderror">
                    <label class="col-form-label">Rate (%)</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="rate" placeholder="Enter Rate" value="{{ old('rate') }}">
                    <span class="messages popover-valid">
                        @error('rate')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group  @error('loan_amount') has-error @enderror">
                    <label class="col-form-label">Total Payable Amount</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="loan_amount" placeholder="Enter Loan Amount" value="{{ old('loan_amount') }}">
                    <span class="messages popover-valid">
                        @error('loan_amount')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('max_installment') has-error @enderror">
                    <label class="col-form-label">Installment</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="max_installment" placeholder="Enter Total Installment" value="{{ old('max_installment') }}">
                    <span class="messages popover-valid">
                        @error('max_installment')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 form-group @error('loan_date') has-error @enderror">
                    <label class="col-form-label">Loan Date</label>
                    <input autocomplete="off" type="text" class="form-control today-datepicker" name="loan_date" placeholder="Enter Loan date" value="{{ old('loan_date') }}">
                    <span class="messages popover-valid">
                        @error('loan_date')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('late_fee') has-error @enderror">
                    <label class="col-form-label">Late Fee</label>
                    <input autocomplete="off" type="text" class="form-control autonumber" name="late_fee" placeholder="Enter Late Fee" value="{{ old('late_fee') }}">
                    <span class="messages popover-valid">
                        @error('late_fee')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('start_installment_date') has-error @enderror">
                    <label class="col-form-label">Start Installment Date</label>
                    <input autocomplete="off" type="text" class="form-control today-datepicker" name="start_installment_date" placeholder="Enter Scheme Start date" value="{{ old('start_installment_date') }}">
                    <span class="messages popover-valid">
                        @error('start_installment_date')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>

                <div class="col-md-3 form-group @error('end_installment_date') has-error @enderror">
                    <label class="col-form-label">End Installment Date</label>
                    <input autocomplete="off" type="text" class="form-control single-datepicker" name="end_installment_date" placeholder="Enter Scheme End date" value="{{ old('end_installment_date') }}">
                    <span class="messages popover-valid">
                        @error('end_installment_date')
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                        @enderror
                    </span>
                </div>
            </div>
            {{-- protected $fillable = [
                '','','','nominee_id','loan_scheme_id','late_fee','rate','total_payable_amount',
                'total_installment_no','remarks','account_status'
            ]; --}}


            <div class="col-md-12 form-group row @error('remarks') has-error @enderror" style="padding-right: 0px">
                <label class="ol-form-label">Remarks</label>
                <textarea rows="5" name="remarks" class="form-control" placeholder="Enter Remarks">{{old('remarks')}}</textarea>
                <span class="messages popover-valid">
                    @error('remarks')
                        <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="{{$message}}"></i>
                    @enderror
                </span>
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
    $(document).on('change','select[name="loan_scheme_id"]',function (params) {
        var element = $(this).find('option:selected');
        var form = $(this).closest('form');
        alert(element.attr('min_amount'));
    })
</script>

@endsection
