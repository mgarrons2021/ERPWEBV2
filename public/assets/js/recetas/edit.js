const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let actualizar_receta = document.getElementById("actualizar_receta");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control cantidad");
let precios = document.getElementsByClassName("precio");
let td_subtotales = document.getElementsByClassName("td_subtotal");

let td_total_plato2 =  document.getElementById("total_plato2");
let total = document.getElementById("total");
let plato_id = document.getElementById("plato_id");
let array_cantidad = [];
let array_subtotales = [];
let array_receta_id_a_editar = [];
let array_receta_id_a_eliminar = [];

$("body").on("change", ".checkbox-editar", function () {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                stocks_input[i].removeAttribute("readonly");
            } else {
                stocks_input[i].setAttribute("readonly", true);
            }
        }
    }
});
$("body").on("keyup", ".cantidad", function () {
   
    for (let i in checboxs_editar) {
        let precio = precios[i];
        let cantidad = stocks_input[i];
        let subtotal = td_subtotales[i];
        subtotal.innerHTML = (cantidad.value * precio.innerHTML).toFixed(4);
    }
    let total_p = 0;
    for (let j in td_subtotales) {
        if (
            td_subtotales[j].innerHTML !== undefined &&
            !isNaN(td_subtotales[j].innerHTML)
        ) {
            total_p += parseFloat(td_subtotales[j].innerHTML);
        }
    }
    td_total_plato2.innerHTML = total_p.toFixed(4);
    console.log(td_total_plato2)
  
});
actualizar_receta.addEventListener("click", function () {
    detallesAEditar();
    detallesAEliminar();
    fetch(ruta_actualizarReceta, {
        method: "POST",
        body: JSON.stringify({
            plato_id: plato_id.value,
            cantidades: array_cantidad,
            subtotales: array_subtotales,
            detallesAEditar_id: array_receta_id_a_editar,
            detallesAEliminar_id: array_receta_id_a_eliminar,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Registro agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                       window.location.href = ruta_platos; 
                    },
                });
            }
        })
        .catch((error) => console.error(error));
    array_stocks = [];
    array_subtotales = [];
    array_receta_id_a_editar = [];
    array_receta_id_a_eliminar = [];
});

function detallesAEditar() {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                array_cantidad.push(stocks_input[i].value);
                array_subtotales.push(td_subtotales[i].innerHTML);
                array_receta_id_a_editar.push(checkbox_editar.value);
            }
        }
    }
    console.log(array_receta_id_a_editar);
}

function detallesAEliminar() {
    for (let i in checboxs_eliminar) {
        let checkbox_eliminar = checboxs_eliminar[i];
        if (checkbox_eliminar.value != undefined) {
            if (checkbox_eliminar.checked) {
                array_receta_id_a_eliminar.push(checkbox_eliminar.value);
            }
        }
    }
}
