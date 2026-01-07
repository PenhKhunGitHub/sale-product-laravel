@include('header')
<style>

</style>
<div class="m-3">
    <div class="card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center pl-2 pr-2 pt-1 pb-1">
            <div class="ml-2" style="font-size: 14px;font-weight: bold; color:gray">
                <a href="{{ route('home') }}">Home</a> &nbsp;
                <i class="fa fa-chevron-right fs-12" style="font-size: 14px;font-weight: bold;"></i> &nbsp;Setup Product
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productModal"
                style="font-size: 14px;font-weight: bold;">Create</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="product_datatables" class="table table-bordered table-hover " width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Unit Price</th>
                                    <th>Sale Price</th>
                                    <th>Description</th>
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

    {{-- Modal Create --}}
    <div class="modal fade" id="productModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-pencil-alt" style="font-size:18px"></i> &nbsp;<div class="modal-title"
                        style="font-size: 20px;font-weight: bold;"> Create Product</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="row mb-3">
                            <label for="product_name" class="col-sm-3 col-form-label label-modal">Product Name <span
                                    class="require_label red-icon">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="product_name" class="form-control form-control-square"
                                    placeholder="Enter Product Name" required>
                                <div class="invalid-feedback">Please enter a product name.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="category_name" class="col-sm-3 col-form-label label-modal">Category Name <span
                                    class="require_label red-icon">*</span></label>
                            <div class="col-sm-9">
                                <select id="category_name" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-sm-3 col-form-label label-modal">Title</label>
                            <div class="col-sm-9">
                                <input type="input" id="title" class="form-control" placeholder="Enter Title"
                                    required>
                                <div class="invalid-feedback">Please enter a Title.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="unit_price" class="col-sm-3 col-form-label label-modal">Unit Price</label>
                            <div class="col-sm-9">
                                <input type="input" id="unit_price" class="form-control"
                                    placeholder="Enter Unit Price" required>
                                <div class="invalid-feedback">Please enter a valid unit price.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sale_price" class="col-sm-3 col-form-label label-modal">Sale Price</label>
                            <div class="col-sm-9">
                                <input type="input" id="sale_price" class="form-control"
                                    placeholder="Enter Sale Price">
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
                <div class="modal-footer action-group">
                    <button type="button" class="btn btn-secondary bold" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary bold" onclick="saveProduct()"><i
                            class="fa fa-check-square-o"></i> Save Product</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Update --}}
    <div class="modal fade" id="productUpdateModal" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-pencil-alt" style="font-size:18px"></i> &nbsp;<div class="modal-title"
                        style="font-size: 20px;font-weight: bold;"> Update Product</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="row mb-3">
                            <label for="product_name" class="col-sm-3 col-form-label label-modal">Product Name <span
                                    class="require_label red-icon">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="up_product_name" class="form-control"
                                    placeholder="Enter Product Name" required>
                                <div class="invalid-feedback">Please enter a product name.</div>
                                <input type="hidden" name="product_id" id="product_id">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="category_name" class="col-sm-3 col-form-label label-modal">Category Name <span
                                    class="require_label red-icon">*</span></label>
                            <div class="col-sm-9">
                                <select id="up_category_name" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-sm-3 col-form-label label-modal">Title</label>
                            <div class="col-sm-9">
                                <input type="input" id="up_title" class="form-control" placeholder="Enter Title"
                                    required>
                                <div class="invalid-feedback">Please enter a Title.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="unit_price" class="col-sm-3 col-form-label label-modal">Unit Price</label>
                            <div class="col-sm-9">
                                <input type="input" id="up_unit_price" class="form-control"
                                    placeholder="Enter Unit Price" required>
                                <div class="invalid-feedback">Please enter a valid unit price.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="sale_price" class="col-sm-3 col-form-label label-modal">Sale Price</label>
                            <div class="col-sm-9">
                                <input type="input" id="up_sale_price" class="form-control"
                                    placeholder="Enter Sale Price">
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
                <div class="modal-footer action-group">
                    <button type="button" class="btn btn-secondary bold" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning bold" onclick="updateProduct()"><i
                            class="fa fa-check-square-o"></i> Update Product</button>
                </div>
            </div>
        </div>
    </div>

</div>
@include('footer')
<script text="text/javascript">
    var product_name = $('#product_name');
    var category_id = $('#category_name');
    var title = $('#title');
    var unit_price = $('#unit_price');
    var sale_price = $('#sale_price');
    var description = $('#description');
    var openModal = $('#productModal');

    var product_id = $('#product_id')
    var up_product_name = $('#up_product_name');
    var up_category_id = $('#up_category_name');
    var up_title = $('#up_title');
    var up_unit_price = $('#up_unit_price');
    var up_sale_price = $('#up_sale_price');
    var up_description = $('#up_description');
    var openUpdateModal = $('#productUpdateModal');
    var dataTableElement = $('#product_datatables');

    function clearForm() {
        product_name.val('');
        category_id.val('');
        title.val('');
        unit_price.val('');
        sale_price.val('');
        description.val('');
    }

    if (dataTableElement.length > 0) {
        dataTableElement.DataTable({
            processing: true,
            serverSide: true,

            buttons: [
                'copy',
                'excel',
                'pdf',
                'print',
            ],
            ajax: '{{ route('product.show') }}',
            order: [
                [1, "desc"]
            ],
            columns: [{
                    render: function(data, type, row, meta) {
                        return (meta.row + 1);
                    },
                    name: 'id',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    name: 'action',
                    data: 'action',
                    className: 'text-center', //
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'unit_price',
                    name: 'unit_price'
                },
                {
                    data: 'sale_price',
                    name: 'sale_price'
                },
                {
                    data: 'description',
                    name: 'description'
                },
            ],
            drawCallback: function(res) {
                JsonData = [];
                const { json } = res;
                if (json !== undefined && typeof json.jsonData === 'object') {
                    JsonData = json.jsonData;
                }
            }
        });
    }

    function saveProduct() {
        $.ajax({
            type: 'POST',
            url: '{{ route('product.store') }}',
            data: {
                product_name: product_name.val(),
                category_id: category_id.val(),
                title: title.val(),
                unit_price: unit_price.val(),
                sale_price: sale_price.val(),
                description: description.val(),
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
                openModal.modal('hide')
                clearForm();
            }
        })
    }

    function editProduct(id) {
        console.log(id)
        $.ajax({
            type: 'PUT',
            url: '{{ route('product.edit', ':id') }}'.replace(':id', id),
            data: {
                id: id
            }
        }).done(function(response) {
            if (response.status == 200) {
                product_id.val(response.data.id);
                up_product_name.val(response.data.product_name);
                up_category_id.val(response.data.category_id);
                up_title.val(response.data.title);
                up_unit_price.val(response.data.unit_price);
                up_sale_price.val(response.data.sale_price);
                up_description.val(response.data.description);
            }
        })
    }

    function updateProduct() {
        $.ajax({
            type: 'PUT',
            url: '{{ route('product.update', ':id') }}'.replace(':id', product_id.val()),
            data: {
                product_name: up_product_name.val(),
                category_id: up_category_id.val(),
                title: up_title.val(),
                unit_price: up_unit_price.val(),
                sale_price: up_sale_price.val(),
                description: up_description.val(),
            }
        }).done(function(response) {
            if (response.status == 200) {
                openUpdateModal.modal('hide');
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

    function deleteProduct(id) {
        swal({
                title: "Delete",
                text: `Are you sure you want to delete this product?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false
            })
            .then((confirm) => {
                if (confirm == true) {
                    $.ajax({
                        url: '{{ route('category.destroy', ':id') }}'.replace(':id', id),
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
