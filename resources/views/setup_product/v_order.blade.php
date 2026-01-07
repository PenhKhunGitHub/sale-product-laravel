@include('header')
<style>
    .red-icon {
        color: red;
    }
    .font-weight-bold{
        font-weight: bold;
    }
</style>
<div class="m-3">
    <div class="card mb-2">
        <div class="card-header d-flex justify-content-between align-items-center pl-2 pr-2 pt-1 pb-1">
            <div class="ml-2" style="font-size: 14px;font-weight: bold; color:gray">
                <a href="{{ route('home') }}">Home</a> &nbsp;
                <i class="fa fa-chevron-right fs-12" style="font-size: 14px;font-weight: bold;"></i> &nbsp;Setup Order
            </div>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal"
                style="font-size: 14px;font-weight: bold;">Create</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order_datatables" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Counpon</th>
                                    <th>Status</th>
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

    {{-- Modal Create --}}
    <div class="modal fade" id="orderModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-pencil-alt" style="font-size:18px"></i> &nbsp;<div class="modal-title" style="font-size: 20px;font-weight: bold;"> Create Order</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <div class="row mb-3">
                            <label for="user_name" class="col-sm-3 col-form-label label-modal">User Name <span class="require_label red-icon">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" aria-label="Default select example" id="user_name">
                                    <option></option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                    </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label label-modal">Email <span class="require_label red-icon">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="email" class="form-control" placeholder="Enter Email" required>
                                <div class="invalid-feedback">Please enter Email.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-sm-3 col-form-label label-modal">Phone</label>
                            <div class="col-sm-9">
                                <input type="input" id="phone" class="form-control" placeholder="Enter Phone" required>
                                <div class="invalid-feedback">Please enter Phone.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-sm-3 col-form-label label-modal">Address</label>
                            <div class="col-sm-9">
                                <input type="input" id="address" class="form-control" placeholder="Enter Address" required>
                                <div class="invalid-feedback">Please enter a Adresss.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="conpoun" class="col-sm-3 col-form-label label-modal">Counpon</label>
                            <div class="col-sm-9">
                                <input type="input" id="counpon" class="form-control" placeholder="Enter Counpon">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="discount" class="col-sm-3 col-form-label label-modal">Discount</label>
                            <div class="col-sm-9">
                                <input type="input" id="discount" class="form-control" placeholder="Enter Discount">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-sm-3 col-form-label label-modal">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select" aria-label="Default select example" id="status">
                                    <option></option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                    </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer action-group">
                    <button type="button" class="btn btn-secondary bold" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary bold" onclick="saveOrder()"><i class="fa fa-check-square-o"></i> Save Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script text="text/javascript">
    const user_name = $('#user_name');
    const email = $('#email');
    const phone = $('#phone');
    const address = $('#address');
    const counpon = $('#counpon');
    const status = $('#status');

    const openModal  = $('#orderModal');

    var product_id = $('#product_id')
    var up_user_name = $('#up_user_name');
    var up_email = $('#up_category_name');
    var up_title = $('#up_title');
    var up_address = $('#up_address');
    var up_counpon = $('#up_counpon');
    var up_discount = $('#up_discount');
    var openUpdateModal = $('#productUpdateModal');
    var dataTableElement = $('#order_datatables');

    function clearForm(){
        user_name.val('');
        email.val('');
        phone.val('');
        address.val('');
        conpoun.val('');
        discount.val('');
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
        ajax: '{{ route("order.show") }}',
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
                className: 'text-center',
                orderable: false,
                searchable: false
            },
            {
                render: function(data, type, row) {
                    return "<span class=" + (row.user_id == 1 ? 'text-dark' : 'text-success') + ">" + (row.user_id == 1 ? "Admin" : "User") + "</span>";
                },
                name: 'user_id',
                className: 'text-center'
            },

            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'counpon', name: 'counpon' },
            {
                render: function(data, type, row) {
                    return "<span class=" + (row.status == 0 ? 'text-danger' : 'text-success') + ">" + (row.status == 0 ? "Inactive" : "Active") + "</span>";
                },
                name: 'status',
                className: 'text-center'
            },
            { data: 'created_at', name: 'created_at' },
        ],
        drawCallback: function(res) {
            orderJsonData = [];
            const {
                json
            } = res;
            if (json !== undefined && typeof json.jsonData === 'object') {
                orderJsonData = json.jsonData;
            }
        }
    });

    function saveOrder() {
        $.ajax({
            type: 'POST',
            url: '{{ route("order.store") }}',
            data: {
                user_id : user_name.val(),
                order_id: "0",
                email : email.val(),
                phone : phone.val(),
                address : address.val(),
                counpon : counpon.val(),
                status : status.val(),
            }
        }).done(function(response) {
            if (response.status == 200) {
                openModal.modal('hide')
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

    function editProduct(id) {
        console.log(id)
        $.ajax({
            type: 'PUT',
            url: '{{ route("product.edit",":id") }}'.replace(':id', id),
            data: {
                id : id
            }
        }).done(function(response) {
            if (response.status == 200) {
                product_id.val(response.data.id);
                up_user_name.val(response.data.user_name);
                up_email.val(response.data.email);
                up_title.val(response.data.title);
                up_address.val(response.data.address);
                up_counpon.val(response.data.counpon);
                up_discount.val(response.data.discount);
            }
        })
    }

    function updateProduct() {
        $.ajax({
            type: 'PUT',
            url: '{{ route("product.update",":id") }}'.replace(':id', product_id.val()),
            data: {
                user_name : up_user_name.val(),
                email : up_email.val(),
                title : up_title.val(),
                address : up_address.val(),
                counpon : up_counpon.val(),
                discount : up_discount.val(),
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
