$(document).ready(function () {
    let selectedCells = [];

    function updateSelectedCount() {
        $("#selectedCount").text(selectedCells.length);
    }

    function clearTemporarySelection() {
        $(".leave-checkbox").removeClass("border border-danger");
        selectedCells = [];
        updateSelectedCount();
    }

    $(".leave-checkbox").on("click", function (e) {
        if (e.shiftKey) {
            e.preventDefault();

            const key = $(this).data("staff") + "_" + $(this).data("day");

            if (!selectedCells.includes(key)) {
                selectedCells.push(key);
                $(this).addClass("border border-danger");
            } else {
                selectedCells = selectedCells.filter((item) => item !== key);
                $(this).removeClass("border border-danger");
            }

            updateSelectedCount();
        }
    });

    $("#markSelectedLeave").on("click", function () {
        selectedCells.forEach(function (item) {
            const parts = item.split("_");
            const staffId = parts[0];
            const day = parts[1];

            $(`.leave-checkbox[data-staff="${staffId}"][data-day="${day}"]`)
                .prop("checked", true)
                .removeClass("border border-danger");
        });

        clearTemporarySelection();
        notyf.success("Selected cells marked as leave");
    });

    $("#unmarkSelectedLeave").on("click", function () {
        selectedCells.forEach(function (item) {
            const parts = item.split("_");
            const staffId = parts[0];
            const day = parts[1];

            $(`.leave-checkbox[data-staff="${staffId}"][data-day="${day}"]`)
                .prop("checked", false)
                .removeClass("border border-danger");
        });

        clearTemporarySelection();
        notyf.success("Selected leave removed");
    });

    $("#cancelSelectionBtn").on("click", function () {
        clearTemporarySelection();
        notyf.success("Selection cleared");
    });

    $("#saveSelectionBtn").on("click", function () {
        let finalData = [];

        const urlParams = new URLSearchParams(window.location.search);
        let month = urlParams.get("month") || new Date().getMonth() + 1;
        let year = urlParams.get("year") || new Date().getFullYear();

        $(".leave-checkbox:checked").each(function () {
            let day = $(this).data("day");

            let formattedDate =
                year +
                "-" +
                String(month).padStart(2, "0") +
                "-" +
                String(day).padStart(2, "0");

            finalData.push({
                staff_id: $(this).data("staff"),
                day: formattedDate,
            });
        });

        if (finalData.length === 0) {
            Swal.fire("Warning", "Please select at least one day", "warning");
            return;
        }

        $.ajax({
            url: `/staff/add-leave`,
            type: "POST",
            data: {
                data: finalData,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                Swal.fire({
                    title: "Saving...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Saved!",
                    text: response.message || "Leaves saved successfully",
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: xhr.responseJSON?.message || "Something went wrong",
                });
            },
        });
    });
});
