let $doctor, $fecha, $especialidad, $horas;
let iRadio;
const alertaSinHoras = `<div class="alert alert-danger" role="alert">
<strong>Lo sentimos!</strong> No se encontraron horas disponibles para
el médico elegido.
</div>`;

$(function() {
    $especialidad = $("#especialidad");
    $doctor = $("#doctor");
    $fecha = $("#fecha");
    $horas = $("#horas");
    $especialidad.change(() => {
        const especialidadId = $especialidad.val();
        const url = `/api/especialidades/${especialidadId}/doctores`;
        $.getJSON(url, doctoresCargados);
    });

    $doctor.change(cargarHoras);
    $fecha.change(cargarHoras);
});

function doctoresCargados(doctores) {
    let htmlOpciones = "";
    doctores.forEach(doctor => {
        htmlOpciones += `<option value="${doctor.id}">${doctor.nombre}</option>`;
    });
    $doctor.html(htmlOpciones);
}

function cargarHoras() {
    const selectedDate = $fecha.val();
    const doctorId = $doctor.val();

    const url = `/api/horarios/horas?fecha=${selectedDate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHoras);
}
function displayHoras(data) {
    if (
        (!data.manana && !data.tarde) ||
        (data.manana.length == 0 && data.tarde.length == 0)
    ) {
        $horas.html(alertaSinHoras);
        return;
    }

    let htmlHoras = "";
    iRadio = 0;

    if (data.manana) {
        const intervalos_manana = data.manana;
        intervalos_manana.forEach(intervalo => {
            htmlHoras += getRadioIntervaloHtml(intervalo);
        });
    }
    if (data.tarde) {
        const intervalos_tarde = data.tarde;
        intervalos_tarde.forEach(intervalo => {
            htmlHoras += getRadioIntervaloHtml(intervalo);
        });
    }
    $horas.html(htmlHoras);
}

function getRadioIntervaloHtml(intervalo) {
    const text = `${intervalo.inicio} - ${intervalo.fin}`;

    return `<div class= "custom-control custom-radio mb-3">
    <input name= "hora_programada" class= "custom-control-input"
    id= "intervalo${iRadio}" type= "radio" value= "${
        intervalo.inicio
    }" required>
    <label class="custom-control-label" for= "intervalo${iRadio++}">
    ${text}</label>
    </div>`;
}
