$(document).ready(function () {
    $("#myTable8").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
        ],
    });

    // Function to wrap text in DataTable cells
    function wrapTextInCells() {
        $("#myTable8 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable8 tr:even").css("background-color", "#eef2fb");
        $("#myTable8 tr:odd").css("background-color", "white");
        $("#myTable8 th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });
    }
    

    // Call the wrapTextInCells function on initial load and whenever the DataTable is redrawn
    $("#myTable8").on("draw.dt", wrapTextInCells);
    wrapTextInCells();
});