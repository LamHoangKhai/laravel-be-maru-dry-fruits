$(document).ready(() => {
    $("#btn").click(function () {
        let divToPrint = $("#DivIdToPrint").html();
        let newWin = window.open("", "Print-Window");
        newWin.document.open();
        newWin.document.write(
            '<html><body onload="window.print()">' +
                divToPrint +
                "</body></html>"
        );
        newWin.document.close();
        setTimeout(function () {
            newWin.close();
        }, 10);
    });
});
