const formatearFecha = fecha => {
    const mes = fecha.getMonth() + 1; // Ya que los meses los cuenta desde el 0
    const dia = fecha.getDate();
    return `${fecha.getFullYear()}-${(mes < 10 ? '0' : '').concat(mes)}-${(dia < 10 ? '0' : '').concat(dia)}`;
};

let tipo_contrato = document.getElementById('tipo_contrato');
let fecha_fin_contrato = document.getElementById('fecha_fin_contrato');
let fecha_inicio_contrato = document.getElementById('fecha_inicio_contrato');
tipo_contrato.addEventListener('change', e => {

    let fecha_inicio_parseada = new Date(fecha_inicio_contrato.value);
    if (tipo_contrato.value == 1) {
        let nueva_fecha_fin = new Date(fecha_inicio_parseada.setMonth(fecha_inicio_parseada.getMonth() +
            3));
        fecha_final_formateada = formatearFecha(nueva_fecha_fin);
        fecha_fin_contrato.value = fecha_final_formateada;
    }

    if (tipo_contrato.value == 2) {
        let nueva_fecha_fin = new Date(fecha_inicio_parseada.setFullYear(fecha_inicio_parseada
            .getFullYear() +
            1));
        fecha_final_formateada = formatearFecha(nueva_fecha_fin);
        fecha_fin_contrato.value = fecha_final_formateada;
    }

    if (tipo_contrato.value == 3) {
        let nueva_fecha_fin = new Date(fecha_inicio_parseada.setFullYear(fecha_inicio_parseada
            .getFullYear() +
            5));
        fecha_final_formateada = formatearFecha(nueva_fecha_fin);
        fecha_fin_contrato.value = fecha_final_formateada;
    }

});


//
let agregar_habilidad = document.getElementById('agregar_habilidad');
let contenido_habilidad = document.getElementById('contenedor_habilidad');

agregar_habilidad.addEventListener('click', e => {
    e.preventDefault();
    let clonado_habilidad = document.querySelector('.clonar_habilidad');
    let clon_habilidad = clonado_habilidad.cloneNode(true);

    clon_habilidad.querySelectorAll("input").forEach(e => e.value = "");
    clon_habilidad.querySelector('#habilidad').className = 'form-control'


    contenido_habilidad.appendChild(clon_habilidad).classList.remove('clonar_habilidad');

    let remover_ocutar = contenido_habilidad.lastChild.childNodes[1].querySelectorAll('span');
    remover_ocutar[0].classList.remove('ocultar_habilidad');
});


contenido_habilidad.addEventListener('click', e => {
    e.preventDefault();
    if (e.target.classList.contains('puntero_habilidad')) {
        let contenedor_habilidad = e.target.parentNode.parentNode;

        contenedor_habilidad.parentNode.removeChild(contenedor_habilidad);
    }
});

let agregar_experiencia = document.getElementById('agregar_experiencia');
let contenido_experiencia = document.getElementById('contenedor_experiencia');

agregar_experiencia.addEventListener('click', e => {
    e.preventDefault();
    let clonado_experiencia = document.querySelector('.clonar_experiencia');
    let clon_experiencia = clonado_experiencia.cloneNode(true);

    clon_experiencia.querySelectorAll("input").forEach(e => e.value = "");
    clon_experiencia.querySelectorAll("textarea").forEach(e => e.value = "");

    contenido_experiencia.appendChild(clon_experiencia).classList.remove('clonar_experiencia');

    let remover_ocutar = contenido_experiencia.lastChild.childNodes[1].querySelectorAll('span');
    remover_ocutar[0].classList.remove('ocultar_experiencia');
});

contenido_experiencia.addEventListener('click', e => {
    e.preventDefault();
    if (e.target.classList.contains('puntero_experiencia')) {
        let contenedor_experiencia = e.target.parentNode.parentNode;

        contenedor_experiencia.parentNode.removeChild(contenedor_experiencia);
    }
});

let agregar_educacion = document.getElementById('agregar_educacion');
let contenido_educacion = document.getElementById('contenedor_educacion');

agregar_educacion.addEventListener('click', e => {
    e.preventDefault();
    let clonado_educacion = document.querySelector('.clonar_educacion');
    let clon_educacion = clonado_educacion.cloneNode(true);

    clon_educacion.querySelectorAll("input").forEach(e => e.value = "");

    contenido_educacion.appendChild(clon_educacion).classList.remove('clonar_educacion');

    let remover_ocutar = contenido_educacion.lastChild.childNodes[1].querySelectorAll('span');
    remover_ocutar[0].classList.remove('ocultar_educacion');
});

contenido_educacion.addEventListener('click', e => {
    e.preventDefault();
    if (e.target.classList.contains('puntero_educacion')) {
        let contenedor_educacion = e.target.parentNode.parentNode;

        contenedor_educacion.parentNode.removeChild(contenedor_educacion);
    }
});


$(document).ready(function() {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function() {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });

    $(".previous").click(function() {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function() {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function() {
        return false;
    })

    let botonActualizar = document.getElementById("actualizar_codigo");
    let inputCodigo = document.getElementById("codigo");

    botonActualizar.addEventListener("click", function() {
        numeroRandom = getRandomIntInclusive(10000, 99999);

        inputCodigo.value = numeroRandom;
    });

    function getRandomIntInclusive(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

});