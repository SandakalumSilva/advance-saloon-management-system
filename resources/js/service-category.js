let table = $("#serviceCategoryTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/service-categories",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name" },
        { data: "branch", name: "branch.name" },
        { data: "description" },
        { data: "status_badge", orderable: false, searchable: false },
        { data: "action", orderable: false, searchable: false },
    ],
});

$("#createServiceCategory").click(function () {
    $("#serviceCategoryForm")[0].reset();
    $("#service_category_id").val("");

    $("#serviceCategoryModalLabel").text("Add Service Category");
    $("#saveServiceCategoryBtn").text("Save");

    $("#serviceCategoryModal").modal("show");
});

$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $("#serviceCategoryForm")[0].reset();
    $("#service_category_id").val("");

    $.ajax({
        url: `/service-categories/${id}/edit`,
        type: "GET",
        success: function (data) {
            $("#service_category_id").val(data.id);
            $("#branch_id").val(data.branch_id);
            $("#name").val(data.name);
            $("#description").val(data.description);
            $("#status").val(data.status ? 1 : 0);

            $("#serviceCategoryModalLabel").text("Update Service Category");
            $("#saveServiceCategoryBtn").text("Update");

            $("#serviceCategoryModal").modal("show");
        },
        error: function (err) {
            console.error(err);
            notyf.error("Failed to load service category data.");
        },
    });
});

$("#serviceCategoryForm").submit(function (e) {
    e.preventDefault();

    let id = $("#service_category_id").val();
    let url = id ? `/service-categories/${id}` : "/service-categories";

    $.ajax({
        url: url,
        method: id ? "PUT" : "POST",
        data: $(this).serialize(),

        success: function (response) {
            $("#serviceCategoryModal").modal("hide");
            table.ajax.reload();

            notyf.success(
                response.message || "Service category saved successfully.",
            );
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                Object.keys(errors).forEach(function (key) {
                    errors[key].forEach(function (message) {
                        notyf.error(message);
                    });
                });
            } else {
                notyf.error(
                    xhr.responseJSON?.message || "Something went wrong!",
                );
                console.log(xhr.responseText);
            }
        },
    });
});

$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "This service category will be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/service-categories/${id}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text:
                            response.message ||
                            "Service category has been deleted.",
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
