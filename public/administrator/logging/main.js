import {
    renderBarCharHttpCode,
    renderBarCharMethod,
    renderBarCharResponseTime,
} from "./render-bar-chart.js";
$(document).ready(function () {
    let date = $("#selectDays").val();
    renderBarCharHttpCode(date);
    renderBarCharMethod(date);
    renderBarCharResponseTime(date);

    $("#selectDays").change((e) => {
        date = e.target.value;
        renderBarCharHttpCode(date);
        renderBarCharMethod(date);
        renderBarCharResponseTime(date);
    });
});
