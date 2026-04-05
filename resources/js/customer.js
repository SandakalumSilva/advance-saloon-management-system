let table = $("#customerTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/customers",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "customer_code" },
        { data: "first_name" },
        { data: "last_name" },
        { data: "phone" },
        { data: "email" },
        { data: "gender" },
        { data: "status_badge", orderable: false, searchable: false },
        { data: "action", orderable: false, searchable: false },
    ],
});

$("#createCustomer").click(function () {
    $("#customerForm")[0].reset();
    $("#customer_id").val("");

    $("#customerModalLabel").text("Add Customer");
    $("#saveCustomerBtn").text("Save");

    $("#customerModal").modal("show");
});

$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $("#customerForm")[0].reset();
    $("#customer_id").val("");

    $.ajax({
        url: `/customers/${id}/edit`,
        type: "GET",
        success: function (data) {
            $("#customer_id").val(data.id);
            $("#first_name").val(data.first_name);
            $("#last_name").val(data.last_name);
            $("#phone").val(data.phone);
            $("#email").val(data.email);
            $("#date_of_birth").val(data.date_of_birth);
            $("#gender").val(data.gender);
            $("#address").val(data.address);
            $("#notes").val(data.notes);
            $("#status").val(data.status ? 1 : 0);

            $("#customerModalLabel").text("Update Customer");
            $("#saveCustomerBtn").text("Update");

            $("#customerModal").modal("show");
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            notyf.error("Failed to load customer data.");
        },
    });
});

$("#customerForm").submit(function (e) {
    e.preventDefault();

    let id = $("#customer_id").val();
    let url = id ? `/customers/${id}` : "/customers";

    $.ajax({
        url: url,
        method: id ? "PUT" : "POST",
        data: $(this).serialize(),
        success: function (response) {
            $("#customerModal").modal("hide");
            table.ajax.reload();
            notyf.success(response.message || "Customer saved successfully.");
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
        text: "This customer will be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/customers/${id}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message || "Customer has been deleted.",
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