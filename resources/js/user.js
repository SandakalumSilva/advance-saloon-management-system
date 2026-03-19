let table = $("#userTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "users",
    columns: [
        { data: "id" },
        { data: "name" },
        { data: "email" },
        { data: "branch" },
        { data: "role" },
        { data: "action", orderable: false },
    ],
});

// CREATE
$("#createUser").click(function () {
    $("#userForm")[0].reset();
    $("#user_id").val("");
    $("#userModal").modal("show");
});

// EDIT
$(document).on("click", ".editBtn", function () {
    let id = $(this).data("id");

    $.get(`/users/${id}/edit`, function (data) {
        $("#user_id").val(data.id);
        $("[name=name]").val(data.name);
        $("[name=email]").val(data.email);
        $("[name=phone]").val(data.phone);
        $("[name=branch_id]").val(data.branch_id);
        $("[name=role_id]").val(data.role.id);
        $("#userModal").modal("show");
    });
});

// SAVE
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

            notyf.success("User saved successfully ✅");
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                Object.keys(errors).forEach(function (key) {
                    errors[key].forEach(function (message) {
                        notyf.error(message); // 🔥 show each error
                    });
                });
            } else {
                // Other errors
                notyf.error("Something went wrong!");
                console.log(xhr.responseText);
            }
        },
    });
});

// DELETE
$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    if (confirm("Delete?")) {
        $.ajax({
            url: `/users/${id}`,
            method: "DELETE",
            data: { _token: "{{ csrf_token() }}" },
            success: function () {
                table.ajax.reload();
            },
        });
    }
});
