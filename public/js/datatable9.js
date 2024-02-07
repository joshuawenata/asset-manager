$(document).ready(function () {
    $("#myTable9").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                },
            },
        ],
    });

    // Function to wrap text in DataTable cells
    function wrapTextInCells() {
        $("#myTable9 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable9 tr:even").css("background-color", "#eef2fb");
        $("#myTable9 tr:odd").css("background-color", "white");
        $("#myTable9 th").each(function () {
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
    $("#myTable9").on("draw.dt", wrapTextInCells);
    wrapTextInCells();
});