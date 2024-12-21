@extends('admin.admin-layouts.master')
@section('page_title','Admin List')
@section('admin_select','active')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<style>
    .manageWidth {
        width: 13rem;
    }

    @media only screen and (max-width: 500px) {
        .manageWidth {
            margin-right: 0.9rem;
            margin-left: 0.5rem;
        }
    }

    @media only screen and (max-width: 700px) {
        .manageWidth {
            margin-right: 0.9rem;
            margin-left: 0.5rem;
        }
    }

    @media only screen and (max-width: 980px) {
        .manageWidth {
            margin-right: 0.9rem;
            margin-left: 0.5rem;
        }
    }
</style>
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div class="d-flex">
            <i class="fa-solid fa-list" style="padding:0.5rem; font-size: 1.5rem;"></i>
            <h3 class="fw-bold mb-3"> {{ $data }} | Child Module List </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 d-flex">
                        <div class="col-md-3">
                            <button id="adminProduct" data-bs-toggle="modal" data-bs-target="#createChildModule" class="btn btn-success card-title">
                                <i class="fa fa-pen me-2"></i>Create Child Module</button>
                        </div>

                        <button id="moduleExcelDownload" data-bs-toggle="modal" data-bs-target="#downloadExcelChildModule" class="btn btn-success card-title">
                            <i class="fa fa-download me-2"></i>Bluk Create Child Module</button>
                        <!-- <form action="{{ url('admin/child-module/sample/download') }}" method="POST">
                            @csrf
                            <button class="btn btn-success card-title"><i class="fa fa-download me-2"></i>Bluk Create Child Module</button>
                        </form> -->

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
                                    <th>Parent Module</th>
                                    <th>Module</th>
                                    <th>Icon</th>
                                    <th>Route</th>
                                    <th>Query</th>
                                    <th>Route Type</th>
                                    <th>Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Parent Module</th>
                                    <th>Module</th>
                                    <th>Icon</th>
                                    <th>Route</th>
                                    <th>Query</th>
                                    <th>Route Type</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if($childModule)
                                    @foreach($childModule as $childModule)
                                        <tr>
                                            <td> {{ $childModule->subModuleFromChild->name }} </td>
                                            <td> {{ $childModule->name }} </td>
                                            <td> {{ $childModule->icon }} </td>
                                            <td> {{ $childModule->route }} </td>
                                            <td> {{ $childModule->query }} </td>
                                            <td>
                                                @if($childModule->route_type == 1)
                                                <p>URL Type</p>
                                                @elseif($childModule->route_type == 2)
                                                <p>Route Type</p>
                                                @else
                                                <p>Other Type</p>
                                                @endif
                                            </td>
                                            <td> {{ $childModule->order }} </td>
                                            <td>
                                                <div class="form-button-action">
                                                    
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
                        <input type="hidden" name="id" id="showId">
                        <div class="modal-dialog">
                            <div class="modal-content" style="width: 50rem;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showModalLabel">Show Child Module Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 showErrorMessage"></div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Sub Module Name</label>
                                                <input name="sub_module_id" id="showParentName" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Child Module Name</label>
                                                <input name="name" id="showName" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Child Module Icon</label>
                                                <input name="icon" id="showIcon" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="message-text" class="col-form-label">Child Module Route</label>
                                                <input name="route" id="showRoute" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="message-text" class="col-form-label">Child Module Route Type</label>
                                                <input name="route_type" id="showRouteType" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="message-text" class="col-form-label">Child Module Query</label>
                                                <input name="query" id="showQuery" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Child Module Order</label>
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
                    </div>

                    <!-- Create Module -->
                    <div class="modal fade" id="createChildModule" tabindex="-1" aria-labelledby="createChildModuleLabel" aria-hidden="true">
                        <form method="POST" id="createChildModuleDetails">
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content" style="width: 50rem;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createChildModuleLabel">Create Child Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 createErrorMessage">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Sub Module Name</label>
                                                    <select name="sub_module_id" placeholder="Sub module name" id="subModuleId" class="form-control @error('sub_module_id') is-invalid @enderror" autocomplete="sub_module_id" autofocus>
                                                        <option selected disabled>select sub module</option>
                                                        @foreach($subModule as $subModule)
                                                            <option value="{{ $subModule->id }}"> {{ $subModule->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Name</label>
                                                    <input name="name" id="childModuleName" type="text" class="form-control" placeholder="child module name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Query</label>
                                                    <input name="query" id="childModuleQuery" type="text" class="form-control" placeholder="Child module query" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child module color code</label>
                                                    <input name="color_code" id="childModuleColorCode" type="text" class="form-control" placeholder="Child module color code" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Icon</label>
                                                    <input name="icon" id="childModuleIcon" type="text" class="form-control" placeholder="Child module icon" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Child Module Route</label>
                                                    <input name="route" id="childModuleRoute" type="text" placeholder="Child Module Route" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <select name="route_type" placeholder="name" id="routeTypeId" type="text" class="form-control @error('route_type') is-invalid @enderror" autocomplete="route_type" autofocus>
                                                        <option selected disabled value="">select route type</option>
                                                        <option value="1">Url</option>
                                                        <option value="2">Route</option>
                                                        <option value="0">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Order</label>
                                                    <input name="order" id="childModuleOrder" placeholder="Child Module Order" type="number" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary createChildModule">Create Child Module</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Update Module -->
                    <div class="modal fade" id="updateSubModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <form method="POST" id="updateBookDetails">
                            @csrf
                            <input type="hidden" name="id" id="updateId">
                            <div class="modal-dialog">
                                <div class="modal-content" style="width: 50rem;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Update Child Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 updateErrorMessage"></div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Sub Module Name</label>
                                                    <select name="sub_module_id" id="updateModuleId" class="form-control">
                                                        <option selected disabled>-- please select sub module --</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Name</label>
                                                    <input name="name" id="updateName" type="text" class="form-control" placeholder="Child Module Name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Icon</label>
                                                    <input name="icon" id="updateChildIcon" type="text" class="form-control" placeholder="Child Module Icon" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Child Module Query</label>
                                                    <textarea type="text" name="query" id="updateChildQuery" placeholder="Child Module Query" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Child Route</label>
                                                    <input type="text" name="route" id="updateChild Route" placeholder="Module Route" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Child Route Type</label>
                                                    <select name="module_id" id="updateChildRouteType" class="form-control">
                                                        <option selected disabled value="">select Child Module Route</option>
                                                        <option value="1"> URL </option>
                                                        <option value="2"> Route </option>
                                                        <option value="0"> Other </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Child Module Color Code</label>
                                                    <input type="text" name="color_code" id="updateChildModuleColorCode" placeholder="Child Module Color Code" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Child Module Order</label>
                                                    <input name="order" id="updateChildModuleOrder" placeholder="Child Module Order" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary updateModuleBtn">Update Child Module</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Execl Download for Sub Module -->
                    <div class="modal fade" id="downloadExcelChildModule" tabindex="-1" aria-labelledby="downloadExcelChildModuleLabel" aria-hidden="true">
                        <form action="{{ url('admin/child-module/sample/download') }}" method="POST" id="downloadExcelChildModuleDetails">
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="downloadExcelChildModuleLabel">Create Child Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 createErrorMessage">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Sub Module Name</label>
                                                    <select name="sub_module_id" placeholder="Sub module name" id="subModuleId" class="form-control @error('sub_module_id') is-invalid @enderror" autocomplete="sub_module_id" autofocus>
                                                        <option selected disabled>select sub module</option>
                                                        @foreach($subModule as $sub)
                                                            <option value="{{ $sub }}"> {{ $sub }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary downloadExcelChildModule">Bluk Create Child Module</button>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('master/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('master/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('master/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('master/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('master/assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let imageUrl = "{{ URL::to('/') }}/admin_assets/images/icon/order.jpg";
        $("#multi-filter-select").DataTable({
            pageLength: 4,
            initComplete: function() {
                var api = this.api();
                var filterColumns = [0, 1, 2, 3, 4, 5, 6];
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

        $(document).on('click', '.createChildModule', function() {
            let data = {
                sub_module_id: document.getElementById('subModuleId').value,
                name: document.getElementById('childModuleName').value,
                query: document.getElementById('childModuleQuery').value,
                icon: document.getElementById('childModuleIcon').value,
                route: document.getElementById('childModuleRoute').value,
                route_type: document.getElementById('routeTypeId').value,
                order: document.getElementById('childModuleOrder').value,
                color_code: document.getElementById('childModuleColorCode').value
            };

            let flag = false;

            for (let key in data) {
                if (data[key] === '') {
                    Swal.fire({
                        title: "Message !!",
                        text: 'Please enter ' + key.replace('_', ' '),
                        imageUrl: imageUrl,
                        imageWidth: 400,
                        imageHeight: 200,
                    });
                    flag = true;
                    break;
                }
            }

            if (flag) return;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('admin/child/module/create') }}",
                contentType: 'application/json',
                processData: false,
                // data: $.param(data), // serialize the data
                data: JSON.stringify(data),
                success: function(response) {
                    $('#createChildModule').modal('hide');
                    $('.table').load(location.href + ' .table');

                    if (response.status === 'success') {
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
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        });

        $(document).on('click', '.updateModule', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let module_id = $(this).data('sub_module_id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let route = $(this).data('route');
            let route_type = $(this).data('route_type');
            let color_code = $(this).data('color_code');
            let query = $(this).data('query');
            let order = $(this).data('order');

            $('#updateId').val(id);
            $('#updateModuleId').val(module_id);
            $('#updateName').val(name);
            $('#updateIcon').val(icon);
            $('#updateRoute').val(route);
            $('#updateRouteType').val(route_type);
            $('#updateColorCode').val(color_code);
            $('#updateQuery').val(query);
            $('#updateOrder').val(order);
        });

        $(document).on('click', '.updateModuleBtn', function(e) {
            let id = $('#updateId').val();
            let name = $('#updateName').val();
            let icon = $('#updateIcon').val();
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

        $(document).on('click', '.showSubModuleData', function(e) {
            console.log("hello");
            e.preventDefault();
            let id = $(this).data('id');
            let module_id = $(this).data('module_id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let route = $(this).data('route');
            let query = $(this).data('query');
            let route_type = $(this).data('route_type');
            let order = $(this).data('order');

            let routeTypeName = '';
            if (route_type == 1) {
                routeTypeName = "URL";
            } else if (route_type == 2) {
                routeTypeName = "Route";
            } else {
                routeTypeName = "Other";
            }

            $('#showId').val(id);
            $('#showParentName').val(module_id);
            $('#showName').val(name);
            $('#showIcon').val(icon);
            $('#showRoute').val(route);
            $('#showQuery').val(query);
            $('#showRouteType').val(routeTypeName);
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
                        url: "{{ url('module/delete') }}/" + moduleId,
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
                                    text: "Your book has been deleted.",
                                    icon: "success"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the book.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '.downloadExcelChildModule', function() {
            let data = {
                subModuleId:document.getElementById('subModuleId').value
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "{{ url('admin/child-module/sample/download') }}",
                data:data,
                success:function(response) {
                    $('#downloadExcelChildModule').modal('hide');
                    if(response) {
                        let atag = document.createElement('a');
                        console.log(atag);
                        
                    } else {

                    }
                    
                },
            });
        })
    });
</script>
@endsection