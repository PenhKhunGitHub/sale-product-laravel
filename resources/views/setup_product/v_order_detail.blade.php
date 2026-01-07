@include('header')
<style>
    .red-icon {
        color: red;
    }
</style>
<div class="m-3">
    <div class="card mb-2">
        <div class="card-header">
            <a href="{{route('home')}}">Home</a> &nbsp;
            <i class="fa fa-chevron-right fs-12"></i> &nbsp;Setup Order Detail
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order_detail_datatables" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>Order Detail Name</th>
                                    <th>Quantity</th>
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
</div>
@include('footer')
<script text="text/javascript">
    var product_name = $('#product_name');
    var category_id = $('#category_name');
    var title = $('#title');
    var unit_price = $('#unit_price');
    var sale_price = $('#sale_price');
    var description = $('#description');
    var openModal  = $('#productModal');

    var product_id = $('#product_id')
    var up_product_name = $('#up_product_name');
    var up_category_id = $('#up_category_name');
    var up_title = $('#up_title');
    var up_unit_price = $('#up_unit_price');
    var up_sale_price = $('#up_sale_price');
    var up_description = $('#up_description');
    var openUpdateModal = $('#productUpdateModal');
    var dataTableElement = $('#product_datatables');

    function clearForm(){
        product_name.val('');
        category_id.val('');
        title.val('');
        unit_price.val('');
        sale_price.val('');
        description.val('');
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
        ajax: '{{ route("product.show") }}',
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
            { data: 'product_name', name: 'product_name' },
            { data: 'category_name', name: 'category_name' },
            { data: 'title', name: 'title' },
            { data: 'unit_price', name: 'unit_price' },
            { data: 'sale_price', name: 'sale_price' },
            { data: 'description', name: 'description' },
        ],
        drawCallback: function(res) {
            JsonData = [];
            const { json } = res;
            if (json !== undefined && typeof json.jsonData === 'object') {
                JsonData = json.jsonData;
            }
        }
    });

    function saveorder_detail() {
        $.ajax({
            type: 'POST',
            url: '{{ route("order_detail.store") }}',
            data: {
                order_detail_name : order_detail_name.val(),
                category_id : category_id.val(),
                title : title.val(),
                unit_price : unit_price.val(),
                sale_price : sale_price.val(),
                description : description.val(),
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

    function editorder_detail(id) {
        console.log(id)
        $.ajax({
            type: 'PUT',
            url: '{{ route("order_detail.edit",":id") }}'.replace(':id', id),
            data: {
                id : id
            }
        }).done(function(response) {
            if (response.status == 200) {
                order_detail_id.val(response.data.id);
                up_order_detail_name.val(response.data.order_detail_name);
                up_category_id.val(response.data.category_id);
                up_title.val(response.data.title);
                up_unit_price.val(response.data.unit_price);
                up_sale_price.val(response.data.sale_price);
                up_description.val(response.data.description);
            }
        })
    }

    function updateorder_detail() {
        $.ajax({
            type: 'PUT',
            url: '{{ route("order_detail.update",":id") }}'.replace(':id', order_detail_id.val()),
            data: {
                order_detail_name : up_order_detail_name.val(),
                category_id : up_category_id.val(),
                title : up_title.val(),
                unit_price : up_unit_price.val(),
                sale_price : up_sale_price.val(),
                description : up_description.val(),
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

    function deleteorder_detail(id) {
        swal({
            title: "Delete",
            text: `Are you sure you want to delete this order_detail?`,
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
