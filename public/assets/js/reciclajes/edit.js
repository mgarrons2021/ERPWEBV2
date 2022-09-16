const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;


let cuerpo_tabla =document.getElementById('cuerpo_tabla');
let table = document.getElementById("table");
let actualizar_reciclaje = document.getElementById("actualizar_reciclaje");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");
let precios = document.getElementsByClassName("precio");

let td_subtotales = document.getElementsByClassName("td_subtotal");
let td_total_reciclaje = document.getElementById("total_reciclaje");
let reciclaje_id = document.getElementById("reciclaje_id");
let agregar_nueva_reciclaje = document.getElementById("agregar_nuevo_reciclaje");
let producto =  document.getElementById('producto');
let cantidad =  document.getElementById('cantidad');
let observacion =  document.getElementById('observacion');

let stock_actual = 0;
let cantidad_ingresada = 0;
/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_stocks = [];
let array_subtotales = [];
let array_detalle_reciclaje_id_a_editar = [];
let array_detalle_reciclaje_id_a_eliminar = [];
let array_detalle_reciclaje_a_agregar= [];
$(document).ready(function () {
    /*DESBLOQUEA LOS INPUTS DE LOS STOCKS*/
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

    /*ACTUALIZA LOS SUBTOTALES Y EL TOTAL INVENTARIO*/
    $("body").on("keyup", ".stock", function () {
        for (let i in stocks_input) {
            let stock = stocks_input[i];
            let precio = precios[i];
            let td_subtotal = td_subtotales[i];
            td_subtotal.innerHTML = (stock.value * precio.innerHTML).toFixed(4);
        }
        let total = 0;
        for (let j in td_subtotales) {
            if (
                td_subtotales[j].innerHTML !== undefined &&
                !isNaN(td_subtotales[j].innerHTML)
            ) {
                total += parseFloat(td_subtotales[j].innerHTML);
            }
        }
        td_total_reciclaje.innerHTML = total.toFixed(4);
    });

    
    $('#producto').select2({}).on("change", function(e) {
    fetch(ruta_obtenerDatosProducto, {
            method: "POST",
            body: JSON.stringify({
                producto_id: e.target.value,
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

            console.log(data);   
            if(data.status!=false){
                let precio = data.precio;
                let unidad_medida = data.unidad_medida;
                let stock_actual = data.stock;
                document.getElementById("stock_actual").value = stock_actual;
                document.getElementById("precio").value = precio;
                document.getElementById("unidad_medida").value = unidad_medida;

            }else{
                iziToast.warning({
                    title: "WARNING",
                    message: "No se pudo obtener el stock actual del Producto. Detalle "+error,
                    position: "topCenter",
                    timeout: 1500,  
                    onClosed: function() {
                        $("#stock_actual").val('');
                    },
                });
            }          
        })
        .catch((error) =>{
            console.log(error)
            iziToast.warning({
                title: "WARNING",
                message: "No se pudo obtener el stock actual del Producto. Detalle "+error,
                position: "topCenter",
                timeout: 1500,  
                onClosed: function() {
                    $("#stock_actual").val('');
                },
            });
            
        });
    });

    $("#cantidad").keyup(function() { 
        stock_actual = $("#stock_actual").val();
        cantidad_ingresada = $("#cantidad").val();
        let stock_nuevo = stock_actual - cantidad_ingresada;
        $("#stock_nuevo").val(stock_nuevo);
    
    });

});

actualizar_reciclaje.addEventListener("click", function () {
    detallesAEditar();
    detallesAEliminar();
    /* ACTUALIZAR INVENTARIO CON FETCH */

    if( array_detalle_reciclaje_id_a_editar.length!=0 || array_detalle_reciclaje_id_a_eliminar.length!=0 || array_detalle_reciclaje_a_agregar.length!=0 ){
        fetch(ruta_actualizarReciclaje, {
            method: "POST",
            body: JSON.stringify({
                reciclaje_id: reciclaje_id.value,
                total_reciclaje: td_total_reciclaje.innerHTML,
                stocks: array_stocks,
                subtotales: array_subtotales,
                detallesAEditar_id: array_detalle_reciclaje_id_a_editar,
                detallesAEliminar_id: array_detalle_reciclaje_id_a_eliminar,
                detallesAAgregar_datos:array_detalle_reciclaje_a_agregar
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
                        window.location.href = ruta_eliminaciones_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
        array_stocks = [];
        array_subtotales = [];
        array_detalle_reciclaje_id_a_editar = [];
        array_detalle_reciclaje_id_a_eliminar = [];

    }else{
        iziToast.info({
            title: "INFORMATION",
            message: "No se realizo ningun cambio para actualizar",
            position: "topRight",
            timeout: 1500,
            
        });

        
    }   
   
});

function detallesAEditar() {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                array_stocks.push(stocks_input[i].value);
                array_subtotales.push(td_subtotales[i].innerHTML);
                array_detalle_reciclaje_id_a_editar.push(
                    checkbox_editar.value
                );
            }
        }
    }
}

function detallesAEliminar() {
    for (let i in checboxs_eliminar) {
        let checkbox_eliminar = checboxs_eliminar[i];
        if (checkbox_eliminar.value != undefined) {
            if (checkbox_eliminar.checked) {
                array_detalle_reciclaje_id_a_eliminar.push(
                    checkbox_eliminar.value
                );
            }
        }
    }
}


agregar_nueva_reciclaje.addEventListener("click", function(){

    if (producto.value == "") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if (cantidad.value == "") {
        $("#errorstock").removeClass("d-none");
    } else {
        $("#errorstock").addClass("d-none");
    }
    if (observacion.value == "") {
        $("#errorobservacion").removeClass("d-none");
    } else {
        $("#errorobservacion").addClass("d-none");
    }    

    if (producto.value != "" && cantidad.value != "" && observacion.value != "") {   
        
        var nombre = producto[producto.selectedIndex].text;
        var medida=document.getElementById("unidad_medida").value;
        var precio = document.getElementById("precio").value;
        
        array_detalle_reciclaje_a_agregar.push({
            idProducto: producto.value,
            stock: cantidad.value,
            precio: precio,
            observacion : observacion.value
        });               

        var fila ='<tr>'+
               ' <td style="text-align:center ;">'+                    
                    '<label class="switch">'+
                       ' <input type="checkbox" class="checkbox-editar" value="0">'+
                       ' <span class="slider round"></span>'+
                    '</label>'+
               ' </td>'+
               ' <td style="text-align:center ;">'+
                  '  <label class="switch">'+
                     '   <input type="checkbox" class="checkbox-eliminar" value="0">'+
                      '  <span class="slider round"></span>'+
                   ' </label>'+
               ' </td>'+
               ' <td style="text-align: center;">'+nombre+'</td>'+
               ' <td style="text-align: center;">'+medida+'</td>'+
               ' <td style="text-align: center;">'+
                   ' <input type="number" class="form-control stock" id="stock-0" style="text-align:center" value="'+cantidad.value+'" step="any" readonly>'+
               ' </td>'+
               ' <td style="text-align: center;" class="precio" id="precio-0"> '+precio+' </td>'+
               ' <td style="text-align: center;" class="td_observacion" id="observaciones-0"> '+observacion.value+' </td>'+
               ' <td style="text-align: center;" class="td_subtotal" id="subtotal-0"> '+(precio * cantidad.value)+' </td>'+
            '</tr>';
            console.log( fila );
            cuerpo_tabla.innerHTML += fila;               
            td_total_reciclaje.innerText =
            parseFloat(td_total_reciclaje.innerText) +
            parseFloat(precio) * parseFloat(cantidad.value);            
    }



});




