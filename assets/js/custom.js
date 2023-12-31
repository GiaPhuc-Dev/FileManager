$(document).ready(function () {
    $('#dataTable').DataTable();
    $('#checkAll').on('change', function () {
        if ($(this).is(':checked')) {
            $('.check-item').prop('checked', true);
        } else {
            $('.check-item').prop('checked', false);
        }
    });

    $('.edit-action').on('click', function (e) {
        e.preventDefault();
        let dataJson = $(this).data('type');
        let name = dataJson.name;
        let newName = window.prompt('Tên mới', name);
        if (newName.trim() !== '') {

            $('#form-filemanager input[name="name"]').val(newName);
            $('#form-filemanager input[name="old"]').val(name);
            $('#form-filemanager').submit();

        } else {
            alert('Vui lòng nhập tên');
        }
    });
});