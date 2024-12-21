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
            <h3 class="fw-bold mb-3"> {{ $data }} | Sub Module List </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 d-flex">
                        <div class="col-md-3">
                            <button id="adminProduct" data-bs-toggle="modal" data-bs-target="#createSubModule" class="btn btn-success card-title">
                                <i class="fa fa-pen me-2"></i>Create Sub Module</button>
                        </div>

                        <div class="col-md-3">
                            <button id="moduleExcelDownload" data-bs-toggle="modal" data-bs-target="#downloadExcelSubModule" class="btn btn-success card-title">
                                <i class="fa fa-download me-2"></i>Bluk Create Sub Module</button>
                            <!-- <form action="{{ url('admin/sub-module/sample/download') }}" method="POST">
                                @csrf
                                <button class="btn btn-success card-title"><i class="fa fa-download me-2"></i>Bluk Create Sub Module</button>
                            </form> -->
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
                                @if($subModules)
                                @foreach($subModules as $subModule)
                                <tr>
                                    <td> {{ $subModule->parentModuleFromSub->name }} </td>
                                    <td> {{ $subModule->name }} </td>
                                    <td> {{ $subModule->icon }} </td>
                                    <td> {{ $subModule->route }} </td>
                                    <td> {{ $subModule->query }} </td>
                                    <td>
                                        @if($subModule->route_type == 1)
                                        <p>URL Type</p>
                                        @elseif($subModule->route_type == 2)
                                        <p>Route Type</p>
                                        @else
                                        <p>Other Type</p>
                                        @endif
                                    </td>
                                    <td> {{ $subModule->order }} </td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ url('sub/module/update').'/'.$subModule->id }}" class="btn btn-sm btn-warning updateModule" data-id="{{ $subModule->id }}" data-module_id="{{ $subModule->parentModuleFromSub->name }}" data-name="{{ $subModule->name }}" data-icon="{{ $subModule->icon }}" data-route="{{ $subModule->route }}" data-route_type="{{ $subModule->route_type }}" data-query="{{ $subModule->query }}" data-color_code="{{ $subModule->color_code }}" data-order="{{ $subModule->order }}" data-bs-toggle="modal" data-bs-target="#updateSubModal" style="padding-top: 10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{ url('sub/module/show').'/'.$subModule->id }}" class="btn btn-sm btn-info showSubModuleData me-2 ms-2" data-id="{{ $subModule->id }}" data-module_id="{{ $subModule->parentModuleFromSub->name }}" data-name="{{ $subModule->name }}" data-icon="{{ $subModule->icon }}" data-route="{{ $subModule->route }}" data-route_type="{{ $subModule->route_type }}" data-query="{{ $subModule->query }}" data-color_code="{{ $subModule->color_code }}" data-order="{{ $subModule->order }}" data-bs-toggle="modal" data-bs-target="#showModal" style="padding-top: 10px;"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{ url('sub/module/delete').'/'.$subModule->id }}" data-id="{{ $subModule->id }}" class="btn btn-sm btn-danger deleteModule" style="padding-top: 10px;"><i class="fa-solid fa-trash"></i></a>
                                            <!-- <form action="{{ url('module/delete').'/'.$subModule->id }}" method="POST">
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
                        <input type="hidden" name="id" id="showId">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showModalLabel">Show Sub Module Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 showErrorMessage"></div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Parent Module Name</label>
                                                <input name="module_id" id="showParentName" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Module Name</label>
                                                <input name="name" id="showName" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label>Module Icon</label>
                                                <input name="icon" id="showIcon" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="message-text" class="col-form-label">Module Route</label>
                                                <input name="route" id="showRoute" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="message-text" class="col-form-label">Module Route Type</label>
                                                <input name="route_type" id="showRouteType" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group form-group-default">
                                                <label for="message-text" class="col-form-label">Module Query</label>
                                                <input name="query" id="showQuery" class="form-control" readonly />
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
                    </div>

                    <!-- Create Module -->
                    <div class="modal fade" id="createSubModule" tabindex="-1" aria-labelledby="createSubModuleLabel" aria-hidden="true">
                        <form method="POST" id="createSubModuleDetails">
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createSubModuleLabel">Create Parent Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 createErrorMessage">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Parent Module Name</label>
                                                    <select name="module_id" placeholder="parent module name" id="parentModuleId" type="text" class="form-control @error('module_id') is-invalid @enderror" autocomplete="module_id" autofocus>
                                                        <option selected disabled value="">select module</option>
                                                        @foreach($parentModule as $parent)
                                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Sub Module Name</label>
                                                    <input name="name" id="subModuleName" type="text" class="form-control" placeholder="sub module name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Query</label>
                                                    <input name="query" id="subModuleQuery" type="text" class="form-control" placeholder="sub module query" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Sub module color code</label>
                                                    <input name="color_code" id="subModuleColorCode" type="text" class="form-control" placeholder="sub module color code" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Module Icon</label>
                                                    <input name="icon" id="moduleIcon" type="text" class="form-control" placeholder="sub module icon" />
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Module Route</label>
                                                    <input name="route" id="moduleRoute" type="text" placeholder="Sub Module Route" class="form-control">
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
                                                    <label>Module Order</label>
                                                    <input name="order" id="moduleOrder" placeholder="Sub Module Order" type="number" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary createSubModule">Create Module</button>
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
                                                    <label>Parent Module Name</label>
                                                    <select name="module_id" id="updateModuleId" class="form-control">
                                                        <option selected disabled> {{ $subModule->parentModuleFromSub->name }} </option>
                                                        @foreach($parentModule as $parent)
                                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
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
                                                    <label for="message-text" class="col-form-label">Query</label>
                                                    <textarea type="text" name="query" id="updateQuery" placeholder="Module Query" class="form-control"></textarea>
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
                                                    <label for="message-text" class="col-form-label">Route Type</label>
                                                    <select name="module_id" id="updateRouteType" class="form-control">
                                                        <option selected disabled value="">select parent module name</option>
                                                        <option value="1"> URL </option>
                                                        <option value="2"> Route </option>
                                                        <option value="0"> Other </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label for="message-text" class="col-form-label">Color Code</label>
                                                    <input type="text" name="color_code" id="updateColorCode" placeholder="Module Color Code" class="form-control">
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

                    <!-- Execl Download for Sub Module -->
                    <div class="modal fade" id="downloadExcelSubModule" tabindex="-1" aria-labelledby="downloadExcelSubModuleLabel" aria-hidden="true">
                        <form action="{{ url('admin/sub-module/sample/download') }}" method="POST" id="downloadExcelSubModuleDetails">
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="downloadExcelSubModuleLabel">Create Parent Module</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 createErrorMessage">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Parent Module Name</label>
                                                    <select name="module_id" placeholder="parent module name" id="parentModuleId" type="text" class="form-control @error('module_id') is-invalid @enderror" autocomplete="module_id" autofocus>
                                                        <option selected disabled value="">select module</option>
                                                        @foreach($parentModule as $parent)
                                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary downloadExcelSubModule">Bluk Create Sub Module</button>
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

        $(document).on('click', '.createSubModule', function() {
            let data = {
                module_id: document.getElementById('parentModuleId').value,
                name: document.getElementById('subModuleName').value,
                query: document.getElementById('subModuleQuery').value,
                icon: document.getElementById('moduleIcon').value,
                route: document.getElementById('moduleRoute').value,
                route_type: document.getElementById('routeTypeId').value,
                order: document.getElementById('moduleOrder').value,
                color_code: document.getElementById('subModuleColorCode').value,
            };

            let flag = false;

            for (let x = 0; x < data.length; x++) {
                if (data[x].value == '') {
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
            if (flag) return;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('admin/sub/module/create') }}",
                contentType: 'application/json',
                processData: false,
                data: JSON.stringify(data),
                success: function(response) {
                    $('#createSubModule').modal('hide');
                    $('.table').load(location.href + '.table')
                    if (response.status == 'success') {
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
                // error:function(err) {
                //     if (error) {
                //         let data = [];
                //         data[0] = $('#parentModuleId').html(error.responseJSON.errors.module_id);
                //         data[1] = $('#subModuleName').html(error.responseJSON.errors.name);
                //         data[2] = $('#subModuleQuery').html(error.responseJSON.errors.query);
                //         data[3] = $('#subModuleColorCode').html(error.responseJSON.errors.color_code);
                //         data[4] = $('#moduleIcon').html(error.responseJSON.errors.icon);
                //         data[5] = $('#moduleRoute').html(error.responseJSON.errors.route);
                //         data[6] = $('#routeTypeId').html(error.responseJSON.errors.route_type);
                //         data[7] = $('#moduleOrder').html(error.responseJSON.errors.order);
                //         let flag = false;
                //         for (let x = 0; x < data.length; x++) {
                //             if (data[x].value == "") {
                //                 Swal.fire({
                //                     title: data[x],
                //                     imageWidth: 400,
                //                     imageHeight: 200,
                //                     imageUrl: imageUrl,
                //                     imageAlt: 'Custom image',
                //                     confirmButtonText: 'OK',
                //                 });
                //                 flag = true;
                //                 break;
                //             }
                //         }
                //         if (flag) return;
                //     }
                // }
            });
        });

        $(document).on('click', '.updateModule', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let module_id = $(this).data('module_id');
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

        // bluk create --
        $(document).on('click', '.downloadExcelSubModule', function() {
            let data = {
                parentModuleId: document.getElementById('parentModuleId').value
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('admin/sub-module/sample/download') }}",
                method: "GET",
                data: data,
                success: function(response) {
                    $('#createSubModule').modal('hide');
                    if (response.status === 'success') {
                        const atag = document.createElement("a");
                        $(atag).attr("href",response.excelDownload)
                        $(atag).attr("download",response.fileToBeName)
                        document.body.appendChild(atag);
                        atag.click()

                        setTimeout(function() {
                            window.location.href = response.redirectUrl;
                        }, 1000); 
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'An error  occurred',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                }
            });
        });

    });
</script>
@endsection