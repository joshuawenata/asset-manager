$(document).ready( function () {
    $('#myTable').DataTable();

    $('#exampleTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ]
    } );
} );
