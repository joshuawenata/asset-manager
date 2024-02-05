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

    $("#myTable7").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
        ],
    });

    $("#myTable2").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1],
                },
            },
        ],
    });

    $("#myTable3").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2],
                },
            },
        ],
    });
    
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

    $("#approverTable9").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 7],
                },
            },
        ],
    });

    $("#myTable10").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 8],
                },
            },
        ],
    });
    
    $("#myTable15").DataTable({
        dom: "Blfrtip",
        buttons: [
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                },
            },
        ],
    });


    // Function to wrap text in DataTable cells
    function wrapTextInCells() {
        $("#myTable td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable tr:even").css("background-color", "#eef2fb");
        $("#myTable tr:odd").css("background-color", "white");
        $("#myTable th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });

        $("#myTable7 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable7 tr:even").css("background-color", "#eef2fb");
        $("#myTable7 tr:odd").css("background-color", "white");
        $("#myTable7 th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });

        $("#myTable2 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable2 tr:even").css("background-color", "#eef2fb");
        $("#myTable2 tr:odd").css("background-color", "white");
        $("#myTable2 th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });
        
        $("#myTable3 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable3 tr:even").css("background-color", "#eef2fb");
        $("#myTable3 tr:odd").css("background-color", "white");
        $("#myTable3 th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });
        
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

        $("#approverTable9 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#approverTable9 tr:even").css("background-color", "#eef2fb");
        $("#approverTable9 tr:odd").css("background-color", "white");
        $("#approverTable9 th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });

        $("#myTable10 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable10 tr:even").css("background-color", "#eef2fb");
        $("#myTable10 tr:odd").css("background-color", "white");
        $("#myTable10 th").each(function () {
            $(this).css({
                "background-color": "#b0d1ed", 
                "color": "black", 
                "text-align": "center", 
                "padding": "8px",
                "border": "1px solid #000",
            });
        });

        $("#myTable15 td").each(function () {
            $(this).css({
                "white-space": "normal", 
                "padding": "8px", 
                "border": "1px solid #000", 
                "text-align": "left",
            });
        });
        $("#myTable15 tr:even").css("background-color", "#eef2fb");
        $("#myTable15 tr:odd").css("background-color", "white");
        $("#myTable15 th").each(function () {
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
    $("#myTable").on("draw.dt", wrapTextInCells);
    $("#myTable7").on("draw.dt", wrapTextInCells);
    $("#myTable2").on("draw.dt", wrapTextInCells);
    $("#myTable3").on("draw.dt", wrapTextInCells);
    $("#myTable8").on("draw.dt", wrapTextInCells);
    $("#myTable9").on("draw.dt" , wrapTextInCells);
    $("#approverTable9").on("draw.dt" , wrapTextInCells);
    $("#myTable10").on("draw.dt", wrapTextInCells);
    $("#myTable15").on("draw.dt", wrapTextInCells);

    wrapTextInCells();
});
