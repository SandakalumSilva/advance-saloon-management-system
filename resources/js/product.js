let table = $("#productTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/products",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name" },
        { data: "sku" },
        { data: "branch" },
        { data: "category" },
        { data: "selling_price_formatted" },
        { data: "cost_price_formatted" },
        { data: "stock_qty" },
        { data: "commission" },
        { data: "status_badge", orderable: false, searchable: false },
        { data: "action", orderable: false, searchable: false },
    ],
});

$("#createProduct").click(function () {
    $("#productForm")[0].reset();
    $("#product_id").val("");

    $("#productModalLabel").text("Add Product");
    $("#saveProductBtn").text("Save");

    $("#productModal").modal("show");
});

$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $("#productForm")[0].reset();
    $("#product_id").val("");

    $.ajax({
        url: `/products/${id}/edit`,
        type: "GET",
        success: function (data) {
            $("#product_id").val(data.id);
            $("#branch_id").val(data.branch_id);
            $("#product_category_id").val(data.product_category_id);
            $("#name").val(data.name);
            $("#sku").val(data.sku);
            $("#description").val(data.description);
            $("#selling_price").val(data.selling_price);
            $("#cost_price").val(data.cost_price);
            $("#stock_qty").val(data.stock_qty);
            $("#commission_type").val(data.commission_type);
            $("#commission_value").val(data.commission_value);
            $("#status").val(data.status ? 1 : 0);

            $("#productModalLabel").text("Update Product");
            $("#saveProductBtn").text("Update");

            $("#productModal").modal("show");
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            notyf.error("Failed to load product data.");
        },
    });
});

$("#productForm").submit(function (e) {
    e.preventDefault();

    let id = $("#product_id").val();
    let url = id ? `/products/${id}` : "/products";

    $.ajax({
        url: url,
        method: id ? "PUT" : "POST",
        data: $(this).serialize(),
        success: function (response) {
            $("#productModal").modal("hide");
            table.ajax.reload();
            notyf.success(response.message || "Product saved successfully.");
        },
        error: function (xhr) {
            console.log(xhr.responseText);

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(function (key) {
                    errors[key].forEach(function (message) {
                        notyf.error(message);
                    });
                });
            } else if (xhr.status === 403) {
                notyf.error(
                    xhr.responseJSON?.message || "This action is unauthorized.",
                );
            } else {
                notyf.error(
                    xhr.responseJSON?.message || "Something went wrong!",
                );
            }
        },
    });
});

$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "This product will be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/products/${id}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message || "Product has been deleted.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    });

                    table.ajax.reload();
                },
                error: function (xhr) {
                    Swal.fire({
                        title: "Error!",
                        text:
                            xhr.responseJSON?.message ||
                            "Something went wrong.",
                        icon: "error",
                    });
                },
            });
        }
    });
});
