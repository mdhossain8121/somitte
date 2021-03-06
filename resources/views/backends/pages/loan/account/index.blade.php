@extends('backends.pages.main')
@section('main-body')

<!-- HTML5 Export Buttons table start -->
<div class="card">
    <div class="card-header table-card-header">
        <h5 class="text-inverse">LIST OF LOAN ACCOUNTS</h5>
        <a href="{{route('loan_account.create')}}" class="btn btn-sm btn-primary m-b-20 float-right">+ Add Loan Account</a>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table data-source="{{route('loan_account.data')}}" class="table loan-account-datatable compact table-hover table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 3%">SL</th>
                        <th style="width: 12%">Customer</th>
                        <th style="width: 7%">Account No</th>
                        <th style="width: 10%">Scheme</th>
                        <th style="width: 5%" title="Loan Amount">L. Amount</th>
                        <th style="width: 5%">Rate</th>
                        <th style="width: 5%" title="Total Payable Amount">TP. Amount</th>
                        <th style="width: 5%" title="Total Installment">Tot. Inst.</th>
                        <th style="width: 7%">Loan Date</th>
                        <th style="width: 7%">Start Date</th>
                        <th style="width: 7%">End Date</th>
                        <th style="width: 12%">Nominee</th>
                        <th style="width: 7%">Account Status</th>
                        <th style="width: 7%" data-priority="1">Action</th>
                    </tr>
                    {{-- <tr>
                        <th></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th></th>
                    </tr> --}}
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('backends.partials.datatablescript')
<script type="text/javascript">

    // protected $fillable = [
    //     'account_no','loan_amount','customer_id','nominee_id','loan_scheme_id','late_fee','rate','total_payable_amount',
    //     'total_installment_no','loan_date','start_installment_date','end_installment_date','active_fg','remarks','account_status'
    // ];
    var columns = [
        {
            "data": 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {data: 'customer.name', name: 'customer.name'},
        {data: 'account_no', name: 'account_no'},
        {data: 'loan_scheme.name', name: 'loan_scheme.name'},
        {data: 'loan_amount', name: 'loan_amount'},
        {data: 'rate', name: 'rate'},
        {data: 'total_payable_amount', name: 'total_payable_amount'},
        {data: 'total_installment_no', name: 'total_installment_no'},
        {data: 'loan_date', name: 'loan_date'},
        {data: 'start_installment_date', name: 'start_installment_date'},
        {data: 'end_installment_date', name: 'end_installment_date'},
        {data: 'nominee.name', name: 'nominee.name'},
        {data: 'account_status', name: 'account_status'},
        {data: 'actions', name: 'actions'},
    ];
    var columnDefs = [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 10001, targets: 4 },
            { responsivePriority: 2, targets: -2 }
        ];
    $(document).ready(function(){
        adjustWidth();
        loadDatatableWithColumns($('.loan-account-datatable'),columns);
    });
</script>

@endsection
