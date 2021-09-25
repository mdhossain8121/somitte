@extends('backends.pages.main')
@section('main-body')

<!-- HTML5 Export Buttons table start -->
<div class="card">
    <div class="card-header table-card-header">
        <h5 class="text-inverse">LIST OF SAVINGS SCHEME</h5>
        <a href="{{route('scheme.create')}}" class="btn btn-sm btn-primary m-b-20 float-right">+ Add Savings Scheme</a>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table data-source="{{route('scheme.data')}}" class="table savings-scheme-datatable compact table-hover table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Profit(%)</th>
                        <th>Late Fee</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th><input autocomplete="off" style="width:87%" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" style="width:87%" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" style="width:87%" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" style="width:87%" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th><input autocomplete="off" style="width:87%" type="text" class="form-control filter-datatable" placeholder="search"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('backends.partials.datatablescript')
<script type="text/javascript">
    var columns = [
        {
            "data": 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {data: 'name', name: 'name'},
        {data: 'amount', name: 'amount'},
        {data: 'profit', name: 'profit'},
        {data: 'late_fee', name: 'late_fee'},
        {data: 'status', name: 'status'},
        {data: 'actions', name: 'actions'},
    ]
    $(document).ready(function(){
        loadDatatableWithColumns($('.savings-scheme-datatable'),columns);
    });
</script>

@endsection