@extends('admin.admin-layouts.master')
@section('page_title','Dashboard')
@section('dashboard_select','active')
@section('content')
<style>
    .manageWidth{
        width:13rem;
    }
    @media only screen and (max-width: 500px) {
        .msr{
            margin-top: 1rem;
        }
        .fd-column{
            flex-direction: column;
        }
        #monthlyProduct {
            width: 30rem;
        }
        #yearlyProduct {
            width: 30rem;
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
            <i class="fa-solid fa-cart-shopping" style="padding:0.5rem; font-size: 1.5rem;"></i>
            <h3 class="fw-bold mb-3"> {{ $admin }} | {{ __('Product List') }} </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 d-flex fd-column">
                        <div class="col-md-2 msr">
                            <a href="javascript:void(0);" class="btn btn-success card-title" id="adminProduct">Create Product</a>
                        </div>

                        <div class="col-md-2 msr">
                            <a href="javascript:void(0);" class="btn btn-success card-title" id="vendorProduct">Bulk Product</a>
                        </div>
                        

                        <div class="col-md-2 msr">
                            <a href="javascript:void(0);" class="btn btn-danger card-title" id="vendorProduct">Bulk Delete</a>
                        </div>
                        
                        <div class="col-md-2 me-3 msr">
                            <select name="month" id="monthlyProduct" class="form-control me-3"  >
                                <option value="">month wise product filter</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 msr">
                            <input type="text" onsubmit="fetchYearData(event)" name="month" id="yearlyProduct" placeholder="year wise product filter" class="form-control" />
                        </div>
                        
                        <div class="ms-auto msr">
                        <a href="{{ url('admin/employee/list/page') }}">
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
                                    <th>Product Sku</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Product Sku</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->productsku }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->category }}</td>
                                        <td>{{ $product->previous_price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <button>del</button>
                                        </td>
                                    </tr>
                                @endforeach
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
                var filterColumns = [0, 1, 2, 3, 4];
                
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