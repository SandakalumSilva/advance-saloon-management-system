
    $(document).ready(function () {
        let selectedCells = [];

        function updateSelectedCount() {
            $('#selectedCount').text(selectedCells.length);
        }

        function clearTemporarySelection() {
            $('.leave-checkbox').removeClass('border border-danger');
            selectedCells = [];
            updateSelectedCount();
        }

        $('.leave-checkbox').on('click', function (e) {
            if (e.shiftKey) {
                e.preventDefault();

                const key = $(this).data('staff') + '_' + $(this).data('day');

                if (!selectedCells.includes(key)) {
                    selectedCells.push(key);
                    $(this).addClass('border border-danger');
                } else {
                    selectedCells = selectedCells.filter(item => item !== key);
                    $(this).removeClass('border border-danger');
                }

                updateSelectedCount();
            }
        });

        $('#markSelectedLeave').on('click', function () {
            selectedCells.forEach(function (item) {
                const parts = item.split('_');
                const staffId = parts[0];
                const day = parts[1];

                $(`.leave-checkbox[data-staff="${staffId}"][data-day="${day}"]`)
                    .prop('checked', true)
                    .removeClass('border border-danger');
            });

            clearTemporarySelection();
            notyf.success('Selected cells marked as leave');
        });

        $('#unmarkSelectedLeave').on('click', function () {
            selectedCells.forEach(function (item) {
                const parts = item.split('_');
                const staffId = parts[0];
                const day = parts[1];

                $(`.leave-checkbox[data-staff="${staffId}"][data-day="${day}"]`)
                    .prop('checked', false)
                    .removeClass('border border-danger');
            });

            clearTemporarySelection();
            notyf.success('Selected leave removed');
        });

        $('#cancelSelectionBtn').on('click', function () {
            clearTemporarySelection();
            notyf.success('Selection cleared');
        });

        $('#saveSelectionBtn').on('click', function () {
            let finalData = [];

            $('.leave-checkbox:checked').each(function () {
                finalData.push({
                    staff_id: $(this).data('staff'),
                    day: $(this).data('day')
                });
            });

            console.log(finalData);

            Swal.fire({
                icon: 'success',
                title: 'Demo Saved',
                text: 'Dummy bulk leave data prepared. Next step is connect AJAX / controller.'
            });
        });
    });