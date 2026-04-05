let table = $("#userTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "users",
    columns: [
        { data: "DT_RowIndex", orderable: false, searchable: false },
        { data: "name" },
        { data: "email" },
        { data: "branch" },
        { data: "role" },
        { data: "action", orderable: false },
    ],
});

$("#createUser").click(function () {
    $("#userForm")[0].reset();
    $("#user_id").val("");
    $("#userModal").modal("show");
    $("#userModalLabel").text("Add User");
    $("#submitBtn").text("Save");
});

$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $("#userForm")[0].reset();
    $("#user_id").val("");

    $.ajax({
        url: `/users/${id}/edit`,
        type: "GET",
        success: function (data) {
            $("#user_id").val(data.id);

            // users table
            $("[name=name]").val(data.name ?? "");
            $("[name=email]").val(data.email ?? "");
            $("[name=branch_id]").val(data.branch_id ?? "");

            // role
            if (data.roles && data.roles.length > 0) {
                $("[name=role]").val(data.roles[0].name);
            } else {
                $("[name=role]").val("");
            }

            // staff table
            $("[name=phone]").val(data.staff?.phone ?? "");
            $("[name=gender]").val(data.staff?.gender ?? "");
            $("[name=date_of_birth]").val(data.staff?.date_of_birth ?? "");
            $("[name=address]").val(data.staff?.address ?? "");
            $("[name=join_date]").val(data.staff?.join_date ?? "");
            $("[name=basic_salary]").val(data.staff?.basic_salary ?? "");
            $("[name=status]").val(
                data.staff?.status != null ? Number(data.staff.status) : 1,
            );

            // file input cannot be prefilled for security reasons
            $("[name=photo]").val("");

            $("#userModalLabel").text("Update User");
            $("#submitBtn").text("Update");

            const modal = new bootstrap.Modal(
                document.getElementById("userModal"),
            );
            modal.show();
        },
        error: function (err) {
            console.error(err);
        },
    });
});

$("#userForm").submit(function (e) {
    e.preventDefault();

    let id = $("#user_id").val();
    let url = id ? `/users/${id}` : "/users";

    $.ajax({
        url: url,
        method: id ? "PUT" : "POST",
        data: $(this).serialize(),

        success: function () {
            $("#userModal").modal("hide");
            table.ajax.reload();

            notyf.success("User saved successfully.");
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
                notyf.error("Something went wrong!");
                console.log(xhr.responseText);
            }
        },
    });
});

$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/users/${id}`,
                method: "POST",
                data: {
                    _method: "DELETE",
                },
                success: function () {
                    Swal.fire({
                        title: "Deleted!",
                        text: "User has been deleted.",
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
