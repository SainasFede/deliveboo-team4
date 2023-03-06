import Chart from "chart.js/auto";

if (
    typeof ordersByMonth !== "undefined" &&
    typeof salesByMonth !== "undefined" &&
    ordersByMonth !== undefined &&
    salesByMonth !== undefined
) {
    const dataOrders = {
        labels: ordersByMonth.months,
        datasets: [
            {
                label: "Ordini ricevuti mensilmente",
                backgroundColor: "#18a846",
                data: ordersByMonth.total,
            },
        ],
    };

    const dataSales = {
        labels: salesByMonth.months,
        datasets: [
            {
                label: "Fatturato Mensile",
                backgroundColor: "#1b5622",
                borderColor: "#18a846",
                data: salesByMonth.sales,
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 7.5
            },
        ],
    };

    const configOrders = {
        type: "bar",
        data: dataOrders,
        options: {},
    };

    const configSales = {
        type: "line",
        data: dataSales,
        options: {},
    };

    new Chart(document.getElementById("chartOrders"), configOrders);
    new Chart(document.getElementById("chartSales"), configSales);
}
