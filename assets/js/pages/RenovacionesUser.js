let tblRenovacion;
let tblRenovacionT1;
let tblRenovacionAnticipada;

document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        tblRenovacion = $('#tblRenovacion').DataTable({
            ajax: {
                url: 'renovacion.php',
                dataSrc: 'data'
            },
            columns: [
                { data: 'razon' },
                { data: 'cuenta' },
                { data: 'id_cliente' },
                { data: 'dn' },
                { data: 'fecha' },
            ],

            dom: 'Bfrtip',

            buttons:[
                {
                    extend: 'excelHtml5',
                    text:   '<i class="fa-regular fa-file-excel"></i>',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success'
                }
            ],

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            },
            responsive: true
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        tblRenovacionT1 = $('#tblRenovacionT1').DataTable({
            ajax: {
                url: 'renovacionAnticipadaT1.php',
                dataSrc: 'data'
            },
            columns: [
                { data: 'razon' },
                { data: 'cuenta' },
                { data: 'id_cliente' },
                { data: 'dn' },
                { data: 'fecha' },
            ],

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            },
            responsive: true
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        tblRenovacionAnticipada = $('#tblRenovacionAnticipada').DataTable({
            ajax: {
                url: 'renovacionAnticipada.php',
                dataSrc: 'data'
            },
            columns: [
                { data: 'razon' },
                { data: 'cuenta' },
                { data: 'id_cliente' },
                { data: 'dn' },
                { data: 'fecha' },
            ],

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            },
            responsive: true
        });
    });
});