let table = $("#productCategoryTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/product-categories",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name" },
        { data: "branch", name: "branch.name" },
        { data: "description" },
        { data: "status_badge", orderable: false },
        { data: "action", orderable: false },
    ],
});

$("#createProductCategory").click(function () {
    $("#productCategoryForm")[0].reset();
    $("#product_category_id").val("");

    $("#productCategoryModalLabel").text("Add Product Category");
    $("#saveProductCategoryBtn").text("Save");

    $("#productCategoryModal").modal("show");
});

$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $.get(`/product-categories/${id}/edit`, function (data) {
        $("#product_category_id").val(data.id);
        $("#product_branch_id").val(data.branch_id);
        $("#product_name").val(data.name);
        $("#product_description").val(data.description);
        $("#product_status").val(data.status ? 1 : 0);

        $("#productCategoryModalLabel").text("Update Product Category");
        $("#saveProductCategoryBtn").text("Update");

        $("#productCategoryModal").modal("show");
    });
});

$("#productCategoryForm").submit(function (e) {
    e.preventDefault();

    let id = $("#product_category_id").val();
    let url = id ? `/product-categories/${id}` : "/product-categories";

    $.ajax({
        url: url,
        method: id ? "PUT" : "POST",
        data: $(this).serialize(),

        success: function (res) {
            $("#productCategoryModal").modal("hide");
            table.ajax.reload();

            notyf.success(res.message);
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            if (xhr.status === 422) {
                Object.values(xhr.responseJSON.errors).forEach((messages) => {
                    messages.forEach((msg) => notyf.error(msg));
                });
            } else {
                notyf.error("Something went wrong");
            }
        },
    });
});

$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                `/product-categories/${id}`,
                { _method: "DELETE" },
                function (res) {
                    table.ajax.reload();
                    notyf.success(res.message);
                },
            );
        }
    });
});
