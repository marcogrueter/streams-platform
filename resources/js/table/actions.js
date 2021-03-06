$(document).ready(function () {

    // Toggle all table actions
    $('[data-toggle="all"]').on('change', function () {

        $(this).closest('table').find(':checkbox').prop('checked', $(this).is(':checked'));
    });

    // Only allow actions if rows are selected.
    $('table').find(':checkbox').on('change', function () {

        if ($(this).closest('table').find(':checkbox:checked').length) {
            $(this).closest('table').find('tfoot').find('button:not([data-ignore])').removeClass('disabled');
        } else {
            $(this).closest('table').find('tfoot').find('button:not([data-ignore])').addClass('disabled');
        }
    });
});
