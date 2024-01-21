import {
    renderBarCharHttpCode,
    renderBarCharMethod,
    renderBarCharResponseTime,
} from "./render-bar-chart.js";
$(document).ready(function () {
    function getRecentDays(count) {
        let recentDays = [];
        for (let i = 0; i < count; i++) {
            let date = new Date();
            date.setDate(date.getDate() - i);
            recentDays.push(date.toISOString().split("T")[0]);
        }
        return recentDays;
    }

    const numberOfDays = 7;

    const recentDays = getRecentDays(numberOfDays);

    const $selectElement = $("#selectDays");

    $.each(recentDays, function (index, day) {
        if (index === 0) {
            $selectElement.append(
                "<option value='" + day + "' selected>" + day + "</option>"
            );
            return;
        }
        $selectElement.append(
            "<option value='" + day + "'>" + day + "</option>"
        );
    });

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
