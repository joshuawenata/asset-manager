$(document).ready( function () {
    $('#myTable').DataTable();

    $('#exampleTable').DataTable({
        ajax: '',
        processing: true,
        search: {
            return: true,
        },
        // serverSide: true,
    });
} );
