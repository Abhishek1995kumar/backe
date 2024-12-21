@extends('admin.admin-layouts.master')
@section('page_title','Admin List')
@section('admin_select','active')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
            <h3 class="fw-bold mb-3"> {{ $data }} | Module List</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 d-flex">
                        <div class="col-md-2 manageWidth" >
                            <button id="adminProduct" data-bs-toggle="modal" data-bs-target="#createModule" class="btn btn-success card-title">
                            <i class="fa fa-pen me-2"></i>Create Module</button>
                        </div>

                        <div class="ms-auto">
                            <a href="{{ url('admin/module/list') }}">
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
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Route</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Route</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if($module)
                                    @foreach($module as $module)
                                        <tr>
                                            <td> {{ $module->name }} </td>
                                            <td> {{ $module->icon }} </td>
                                            <td> {{ $module->route }} </td>
                                            <td> {{ $module->order }} </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ url('module/update').'/'.$module->id }}" class="btn btn-sm btn-warning updateModule" data-id="{{ $module->id }}" data-name="{{ $module->name }}" data-icon="{{ $module->icon }}" data-route="{{ $module->route }}" data-order="{{ $module->order }}" data-bs-toggle="modal" data-bs-target="#updateModal" style="padding-top: 10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="{{ url('module/show').'/'.$module->id }}" data-bs-target="#showModal" data-id="{{ $module->id }}" data-name="{{ $module->name }}" data-icon="{{ $module->icon }}" data-route="{{ $module->route }}" data-order="{{ $module->order }}" data-bs-toggle="modal" style="padding-top: 10px;" class="btn btn-sm btn-info showModuleData"><i class="fa-solid fa-eye"></i></a>
                                                    <a href="{{ url('module/delete').'/'.$module->id }}" data-id="{{ $module->id }}" class="btn btn-sm btn-danger deleteModule" style="padding-top: 10px;"><i class="fa-solid fa-trash"></i></a>
                                                    <!-- <form action="{{ url('module/delete').'/'.$module->id }}" method="POST">
                                                        @csrf
                                                        <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm btn-danger" style="padding:10px;"><i class=""></i></button>
                                                    </form> -->
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Show Module -->
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
                        <form method="POST" id="showModuleDetails">
                            @csrf
                            <input type="hidden" name="id" id="showId">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="showModalLabel">Show Module Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 showErrorMessage"></div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Name</label>
                                                    <input name="name" id="showName" class="form-control" readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Icon</label>
                                                    <input name="icon" id="showIcon" class="form-control" readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Route</label>
                                                    <input name="route" id="showRoute" class="form-control" readonly />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Order</label>
                                                    <input name="order" id="showOrder" class="form-control" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Create Module -->
                    <div class="modal fade" id="createModule" tabindex="-1" aria-labelledby="createModuleLabel" aria-hidden="true">
                        <form method="POST" id="createModuleDetails">
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModuleLabel">Create Parent Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 createErrorMessage">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Name</label>
                                                    <input name="name" id="moduleName" type="text" class="form-control" placeholder="module name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Icon</label>
                                                    <input name="icon" id="moduleIcon" type="text" class="form-control" placeholder="module icon" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Module Route</label>
                                                    <input name="route" id="moduleRoute" type="text" placeholder="Module Route" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Order</label>
                                                    <input name="order" id="moduleOrder" placeholder="Module Order" type="number" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary createModule">Create Module</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Update Module -->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <form method="POST" id="updateBookDetails">
                            @csrf
                            <input type="hidden" name="id" id="updateId">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Update Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 updateErrorMessage"></div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Name</label>
                                                    <input name="name" id="updateName" type="text" class="form-control" placeholder="Module Name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Icon</label>
                                                    <input name="icon" id="updateIcon" type="text" class="form-control" placeholder="Module Icon" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Route</label>
                                                    <input type="text" name="route" id="updateRoute" placeholder="Module Route" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Order</label>
                                                    <input name="order" id="updateOrder" placeholder="Module Order" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary updateModuleBtn">Update Module</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('master/assets/js/core/jquery-3.7.1.min.js') }} "></script>
    <script src="{{ asset('master/assets/js/core/popper.min.js') }} "></script>
    <script src="{{ asset('master/assets/js/core/bootstrap.min.js') }} "></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="{{ asset('master/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


<script>
    $(document).ready(function() {
        let imageUrl = "{{ URL::to('/') }}/admin_assets/images/icon/order.jpg";
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

        $(document).on('click', '.createModule', function() {
            console.log("hello module");
            
            let data = [
                document.getElementById('moduleName'),
                document.getElementById('moduleIcon'),
                document.getElementById('moduleRoute'),
                document.getElementById('moduleOrder'),
            ];

            let flag = false;

            for(let x=0; x<data.length; x++) {
                if(data[x].value == '') {
                    Swal.fire({
                        title: "Message !!",
                        text: 'Please enter ' + data[x].placeholder,
                        imageUrl: imageUrl,
                        imageWidth: 400,
                        imageHeight: 200,
                    });
                    flag = true;
                    break;
                }
            }
            if(flag) return;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                url:"{{ url('admin/module/create') }}",
                data:data,
                success:function(response) {
                    $('#createModule').modal('hide');
                    $('.table').load(location.href + '.table')
                    if(response.status == 'success') {
                        Swal.fire({
                            title: response.message,
                            imageWidth: 400,
                            imageHeight: 200,
                            imageUrl: imageUrl,
                            imageAlt: 'Custom image',
                            confirmButtonText: 'OK',
                        });
                    }
                },
                error:function(err) {
                    if (error) {
                        let data = [];
                        data[0] = $('#moduleName').html(error.responseJSON.errors.name);
                        data[1] = $('#moduleIcon').html(error.responseJSON.errors.icon);
                        data[2] = $('#moduleRoute').html(error.responseJSON.errors.route);
                        data[3] = $('#moduleOrder').html(error.responseJSON.errors.order);
                        let flag = false;
                        for (let x = 0; x < data.length; x++) {
                            if (data[x].value == "") {
                                Swal.fire({
                                    title: data[x],
                                    imageWidth: 400,
                                    imageHeight: 200,
                                    imageUrl: imageUrl,
                                    imageAlt: 'Custom image',
                                    confirmButtonText: 'OK',
                                });
                                flag = true;
                                break;
                            }
                        }
                        if (flag) return;
                    }
                }
            });
        });

        $(document).on('click', '.updateModule', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let route = $(this).data('route');
            let order = $(this).data('order');

            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updateIcon').val(icon);
            $('#updateRoute').val(route);
            $('#updateOrder').val(order);
        });

        $(document).on('click', '.updateModuleBtn', function(e) {
            let id = $('#updateId').val();
            let name  = $('#updateName').val();
            let icon  = $('#updateIcon').val();
            let route = $('#updateRoute').val();
            let order = $('#updateOrder').val();

            Swal.fire({
                title: "Are you sure?",
                text: "You want to edit existing record !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#E5E500",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, edit it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/module/update') }}/" + id,
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id,
                            name: name,
                            icon: icon,
                            route: route,
                            order: order
                        },
                        success: function(response) {
                            console.log(response.message);
                            if (response.status == 'success') {
                                $('#updateModal').modal('hide');
                                $('.table').load(location.href + ' .table');
                                if (response.status) {
                                    Swal.fire({
                                        title: response.message,
                                        imageUrl: imageUrl,
                                        imageWidth: 400,
                                        imageHeight: 200,
                                    });
                                }
                            }
                        },
                        error: function(err) {
                            let data = [];
                            data[0] = err.responseJSON.message.name;
                            data[1] = err.responseJSON.message.icon;
                            data[2] = err.responseJSON.message.route;
                            data[3] = err.responseJSON.message.order;
                            let flag = false;
                            for (let x = 0; x < data.length; x++) {
                                if (data[x] != '') {
                                    Swal.fire({
                                        title: data[x],
                                        imageUrl: imageUrl,
                                        imageWidth: 400,
                                        imageHeight: 200,
                                    });
                                    break;
                                    flag = true;
                                }
                            }
                            if (flag) return;
                        }
                    });
                }
            });
        });
        
        $(document).on('click', '.showModuleData', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let route = $(this).data('route');
            let order = $(this).data('order');

            $('#showId').val(id);
            $('#showName').val(name);
            $('#showIcon').val(icon);
            $('#showRoute').val(route);
            $('#showOrder').val(order);
        });

        $(document).on('click', '.deleteModule', function(e) {
            e.preventDefault();
            let moduleId = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/module/delete') }}/" + moduleId,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: moduleId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('.table').load(location.href + ' .table');
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your parent module has been deleted.",
                                    icon: "success"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the parent module.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection