$(document).ready(function () {
    $("#myTable").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });

    // Function to wrap text in DataTable cells
    function wrapTextInCells() {
        $("#myTable td").each(function () {
            $(this).css("white-space", "normal");
        });
    }

    // Call the wrapTextInCells function on initial load and whenever the DataTable is redrawn
    $("#myTable").on("draw.dt", wrapTextInCells);
    wrapTextInCells();
});
