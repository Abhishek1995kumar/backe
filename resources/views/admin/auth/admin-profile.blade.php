@extends('admin.admin-layouts.master')
@section('page_title','Admin List')
@section('admin_select','active')
@section('content')
<style>
    .manageWidth{
        width:13rem;
    }
    @media only screen and (max-width: 500px) {
        .manageWidth{
            margin-right: 0.9rem;
            margin-left: 0.5rem;
        }
    }
    @media only screen and (max-width: 700px) {
        .manageWidth{
            margin-right: 0.9rem;
            margin-left: 0.5rem;
        }
    }
    @media only screen and (max-width: 980px) {
        .manageWidth{
            margin-right: 0.9rem;
            margin-left: 0.5rem;
        }
    }
</style>
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="d-flex">
            <i class="fa-solid fa-list" style="padding:0.5rem; font-size: 1.5rem;"></i>
            <h3 class="fw-bold mb-3"> {{ $data }} | Employee List</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 d-flex">
                        <div class="col-md-2 manageWidth" >
                            <a href="{{ url('admin/register') }}" class="btn btn-success card-title" id="adminProduct">Single Onboarding</a>
                        </div>

                        <div class="col-md-2 manageWidth">
                            <a href="{{ url('admin/sample/excel/page') }}" class="btn btn-success card-title" id="adminProductSampleExcel">Sample Download</a>
                        </div>

                        <div class="col-md-2 manageWidth">
                            <a href="javascript:void(0);" class="btn btn-danger card-title" id="adminProductBulkDelete">Bulk Delete</a>
                        </div>

                        <div class="col-md-2">
                            <span></span>
                        </div>

                        <div class="ms-auto">
                            <a href="{{ url('admin/tool/dashboard') }}">
                                <h3 class="fw-bold mb-3"> {{ __('Back') }} </h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Role</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Role</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if($admins)
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td> {{ $admin->name }} </td>
                                            <td> {{ $admin->getDepartment->departments }} </td>
                                            <td> {{ $admin->getDesignation->designation }} </td>
                                            <td> {{ $admin->getRole->role_name }} </td>
                                            <td> <img src="{{ asset('documents/self_image/'.$admin->self_image) }}" style="border-radius:5rem;" width="40rem;" height="26rem;" alt="job image" title="job image"> </td>
                                            <td>
                                               <div class="d-flex flex-direction-column">
                                                    <a href="{{ url('edit/profile', $admin->id) }}" class="btn btn-sm btn-warning me-2">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ url('delete/employee', $admin->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                               </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#adminProduct').click(function() {
            loadProductList('admin');
        });
        $('#vendorProduct').click(function() {
            loadProductList('vendor');
        });
        $('#yearlyProduct').click(function() {
            loadProductList('yearly');
        });
        $('#monthlyProduct').click(function() {
            loadProductList('monthly');
        });

        // function loadProductList(type) {
        //     $.ajax({
        //         type:'GET',
        //         url: "{{ url('admin/grocery/product/list') }}",
        //         data: {
        //             type:type,
        //         },
        //         success: function(response) {
        //             if(response.status) {
        //                 $('#multi-filter-select tbody').html(response.html);
        //             } else {
        //                 console.error("Error: ", response.error);
        //             }
        //         },
        //         error: function(err) {
        //             console.error("An error occurred:", err);
        //         }
        //     });
        // }

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function() {
                var api = this.api();

                // filter data by 4 column than use [0,1,2,3] means only 4 column is searchable
                var filterColumns = [0, 1, 2, 3];
                
                // Loop through each column in the DataTable
                api.columns().every(function(index) {
                    if (filterColumns.includes(index)) {
                        var column = this;
                        var select = $(
                            '<select class="form-select"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on("change", function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column
                                .search(val ? "^" + val + "$" : "", true, false)
                                .draw();
                        });

                        column.data().unique().sort().each(function(d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    }
                });
            },
        });
    });
</script>
@endsection