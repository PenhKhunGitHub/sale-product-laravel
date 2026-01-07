@include('header')
<style>

</style>
<div class="m-3">
    <div class="card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center pl-2 pr-2 pt-1 pb-1">
            <div class="ml-2" style="font-size: 14px;font-weight: bold; color:gray">
                <a href="{{ route('home') }}">Home</a> &nbsp;
                <i class="fa fa-chevron-right fs-12" style="font-size: 14px;font-weight: bold;"></i> &nbsp;Setup Category
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal"
                style="font-size: 14px;font-weight: bold;">Create</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="categoryTable" class="display table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px">No</th>
                                    <th style="width: 50px">Action</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Save Modal --}}
    <div class="modal fade" id="categoryModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-pencil-alt" style="font-size:18px"></i> &nbsp;<div class="modal-title" style="font-size: 20px;font-weight: bold;"> Create Category</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="row mb-3">
                            <label for="category_name" class="col-sm-3 col-form-label label-modal">Category Name<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="category_name" class="form-control" placeholder="Enter Category Name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label label-modal">Description</label>
                            <div class="col-sm-9">
                                <textarea id="description" class="form-control" placeholder="Enter Description" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bold" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary bold" onclick="saveCategory()"> Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Update Modal --}}
    <div class="modal fade" id="categoryUpdateModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-pencil-alt" style="font-size:18px"></i> &nbsp;<div class="modal-title" style="font-size: 20px;font-weight: bold;"> Update Category</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="row mb-3">
                            <label for="category_name" class="col-sm-3 col-form-label label-modal">Category Name <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="up_category_name" class="form-control" placeholder="Enter Category Name" required>
                                <input type="hidden" name="category_id" id="category_id">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-sm-3 col-form-label label-modal">Description</label>
                            <div class="col-sm-9">
                                <textarea id="up_description" class="form-control" placeholder="Enter Description" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bold" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning bold" onclick="updateCategory()"> Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script text="text/javascript">
    var category_name = $('#category_name');
    var description = $('#description');
    var category_id = $('#category_id');
    var up_category_name = $('#up_category_name');
    var up_description = $('#up_description');
    var dataTableElement = $('#categoryTable')
    function clearForm(){
        $('#category_name').val("");
        $('#description').val("");
    }

    dataTableElement.DataTable({
        processing: true,
        serverSide: true,
        buttons: [
            'copy',
            'excel',
            'pdf',
            'print',
        ],
        ajax: '{{ route("category.show") }}',
        order: [
            [1, "desc"]
        ],
        columns: [
            {
                render: function(data, type, row, meta) {
                    return (meta.row + 1);
                },
                name: 'id',
                className: 'text-center'
            },
            {
                name: 'action',
                data: 'action',
                className: 'text-center', //
                orderable: false,
                searchable: false
            },
            { data: 'category_name', name: 'category_name' },
            { data: 'description', name: 'description' },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data, type, row) {
                    return new Date(data).toISOString().split('T')[0];
                }
            },
        ],
        drawCallback: function(res) {
            CategoryJsonData = [];
            const {
                json
            } = res;
            if (json !== undefined && typeof json.jsonData === 'object') {
                CategoryJsonData = json.jsonData;
            }
        }
    });

    function saveCategory() {
        $.ajax({
            type: 'POST',
            url: '{{ route("category.store") }}',
            data: {
                category_name: category_name.val(),
                description : description.val()
            }
        }).done(function(response) {
            if (response.status == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                });
                dataTableElement.DataTable().draw();
                $('#categoryModal').modal('hide')
                clearForm();
            }
        })
    }

    function editCategory(id) {
        $.ajax({
            type: 'PUT',
            url: '{{ route("category.edit",":id") }}'.replace(':id', id),
            data: {
                id : id
            }
        }).done(function(response) {
            if (response.status == 200) {
                up_category_name.val(response.data.category_name);
                up_description.val(response.data.description);
                category_id.val(response.data.id);
            }
        })
    }

    function updateCategory() {
        console.log(category_id.val())
        $.ajax({
            type: 'PUT',
            url: '{{ route("category.update",":id") }}'.replace(':id', category_id.val()),
            data: {
                category_name: up_category_name.val(),
                description : up_description.val()
            }
        }).done(function(response) {
            if (response.status == 200) {
                $('#categoryUpdateModal').modal('hide')
                dataTableElement.DataTable().ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                });
                clearForm();
            }
        })
    }

    function deleteCategory(id) {
        swal({
            title: "Delete",
            text: `Are you sure you want to delete this category?`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false
        })
        .then((confirm) => {
            if (confirm == true) {
                $.ajax({
                    url: '{{ route("category.destroy",":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    datatype: 'Json',
                    async: false,
                    data: {
                        id: id
                    },
                    success: response => {
                        if (response.status == 200) {
                            dataTableElement.DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }

</script>


