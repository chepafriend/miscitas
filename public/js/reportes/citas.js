let cantidades = document.querySelector("#container").dataset.user;
cantidades = JSON.parse(cantidades);

Highcharts.chart("container", {
    chart: {
        type: "line"
    },
    title: {
        text: "Citas Registradas mensualmente"
    },

    xAxis: {
        categories: [
            "Ene",
            "Feb",
            "Mar",
            "Abr",
            "May",
            "Jun",
            "Jul",
            "Ago",
            "Sep",
            "Oct",
            "Nov",
            "Dic"
        ]
    },
    yAxis: {
        title: {
            text: "Cantidad de citas"
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [
        {
            name: "Citas Registradas",
            data: cantidades
        }
    ]
});
