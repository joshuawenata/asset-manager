$(document).ready( function () {
    $('#myTable').DataTable();

    $('#exampleTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    } );
} );
