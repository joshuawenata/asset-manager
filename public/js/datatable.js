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

    $('#rusakTable').DataTable( {
        dom: 'B<"clear">lfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ]
    } );

    $('#justTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    } );

    $('#moveTable').DataTable( {
        dom: 'B<"clear">lfrtip',
        buttons: [
            'excel'
        ]
    } );
} );
