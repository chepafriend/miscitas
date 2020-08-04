const reporte = Highcharts.chart("container", {
    chart: {
        type: "column"
    },
    title: {
        text: "Medicos más activos"
    },

    xAxis: {
        categories: [],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: "Citas Atendidas"
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat:
            '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        footerFormat: "</table>",
        shared: true,
        useHTML: true
    },

    series: []
});

let $inicio, $fin;
function fetchData() {
    const fechaInicio = $inicio.val();
    const fechaFin = $fin.val();

    const url = `/reportes/doctores/barra/data?inicio=${fechaInicio}&fin=${fechaFin}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            reporte.xAxis[0].setCategories(data.categorias);

            if (reporte.series.length > 0) {
                reporte.series[1].remove();
                reporte.series[0].remove();
            }

            reporte.addSeries(data.series[0]);
            reporte.addSeries(data.series[1]);
        });
}

$(function() {
    $inicio = $("#fechaInicio");
    $fin = $("#fechaFin");
    fetchData();
    $inicio.change(fetchData);
    $fin.change(fetchData);
});
