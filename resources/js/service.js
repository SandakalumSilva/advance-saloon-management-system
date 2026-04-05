let table = $("#serviceTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/services",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name" },
        { data: "code" },
        { data: "branch" },
        { data: "category" },
        { data: "duration_minutes" },
        { data: "price_formatted" },
        { data: "commission" },
        { data: "status_badge", orderable: false, searchable: false },
        { data: "action", orderable: false, searchable: false },
    ],
});

$("#createService").click(function () {
    $("#serviceForm")[0].reset();
    $("#service_id").val("");

    $("#serviceModalLabel").text("Add Service");
    $("#saveServiceBtn").text("Save");

    $("#serviceModal").modal("show");
});

$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $("#serviceForm")[0].reset();
    $("#service_id").val("");

    $.ajax({
        url: `/services/${id}/edit`,
        type: "GET",
        success: function (data) {
            $("#service_id").val(data.id);
            $("#branch_id").val(data.branch_id);
            $("#service_category_id").val(data.service_category_id);
            $("#name").val(data.name);
            $("#code").val(data.code);
            $("#description").val(data.description);
            $("#duration_minutes").val(data.duration_minutes);
            $("#price").val(data.price);
            $("#cost").val(data.cost);
            $("#commission_type").val(data.commission_type);
            $("#commission_value").val(data.commission_value);
            $("#status").val(data.status ? 1 : 0);

            $("#serviceModalLabel").text("Update Service");
            $("#saveServiceBtn").text("Update");

            $("#serviceModal").modal("show");
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            notyf.error("Failed to load service data.");
        },
    });
});

$("#serviceForm").submit(function (e) {
    e.preventDefault();

    let id = $("#service_id").val();
    let url = id ? `/services/${id}` : "/services";

    $.ajax({
        url: url,
        method: id ? "PUT" : "POST",
        data: $(this).serialize(),
        success: function (response) {
            $("#serviceModal").modal("hide");
            table.ajax.reload();
            notyf.success(response.message || "Service saved successfully.");
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
        text: "This service will be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/services/${id}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message || "Service has been deleted.",
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
