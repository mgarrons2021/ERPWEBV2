
let agregar_insumo = document.getElementById("agregar_insumo");
let precio = document.getElementById("precio");
let producto= document.getElementById("producto");
let producto_nombre= document.getElementById("producto_nombre");
let guardar_pedido = document.getElementById("guardar_pedido");


let cancelar = document.getElementById("cancelar");
let cantidad_solicitada = document.getElementById("cantidad_solicitada");
let subtotal_solicitado = document.getElementById("subtotal_solicitado");

let sucursal= document.getElementById("sucursal");
let sucursal_id = document.getElementById("sucursal_id");

let fecha= document.getElementById("fecha_pedido");

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_pedidos;
});

/* Guardar Los Platos Agregados */

guardar_pedido.addEventListener("click", (e)=>{ 
        fetch(ruta_guardar_pedido, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            }
           
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Parte Produccion Guardado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_parte_producciones;
                    },
                });
           
     
    }
    

})
});


/*AGREGAR INSUMO DE PEDIDO*/

agregar_insumo.addEventListener("click", (e) => {

    console.log("saa");

    if (cantidad_solicitada.value == "") {
        $("#errorcantidad").removeClass("d-none");
    }else{
        $("#errorcantidad").addClass("d-none");
    }

    if (producto.value == "x") {
        $("#errorproducto").removeClass("d-none");
    }else{
        $("#errorproducto").addClass("d-none");
    }
    

    if( (cantidad_solicitada.value.length) >0 && producto.value!="x"){
        subtotal_solicitado.value= (cantidad_solicitada.value * precio.value).toFixed(3);
        fetch(ruta_agregar_insumo, {
            method: "POST",
            body: JSON.stringify({
                detalleParteProduccion: {
                    producto: producto.value,
                    producto_nombre: producto_nombre.value,
                    precio: precio.value,
                    cantidad_solicitada: cantidad_solicitada.value,
                    subtotal_solicitado: subtotal_solicitado.value,
                },
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
            let total =0;
            var opciones = "";
            console.log(data);
            for (let i in data.partes_producciones) {
                total += parseFloat(
                    data.partes_producciones[i].subtotal
                );
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.partes_producciones[i].producto_nombre +
                "</td>";
            
                opciones +=
                    '<td style="text-align: center;">' +
                    data.partes_producciones[i].cantidad_solicitada +
                    "</td>"; 
    
                opciones +=
                    '<td style="text-align: center;">' +
                    data.partes_producciones[i].precio +
                    "</td>";
    
                    opciones +=
                    '<td style="text-align: center;">' +
                    data.partes_producciones[i].subtotal +
                    "</td>";
    
            
    
                
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
            opciones+="<tr>"+
            "</td>" +
            '<td colspan="6" style="text-align: center;" class="table-info">' +
            total +
                " Bs" +
            "</tr>";
            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));

    }else{
        iziToast.warning({
            title: "AVISO",
            message: "Debe rellenar los campos faltantes",
            position: "topCenter",
            timeout: 1500,
            
        });
    }
});






/*Eliminar Insumo Agregado*/
function eliminar(i) {
    fetch(ruta_eliminar_insumo, {
        method: "POST",
        body: JSON.stringify({
            data: i,
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
            let total =0;
            var opciones = "";
            for (let i in data.partes_producciones) {
                total += parseFloat(
                    data.partes_producciones[i].subtotal
                );
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.partes_producciones[i].producto_nombre +
                "</td>";
            
                opciones +=
                    '<td style="text-align: center;">' +
                    data.partes_producciones[i].cantidad_solicitada +
                    "</td>";
                
                opciones+= 
                    '<td style="text-align: center;">' +
                    data.partes_producciones[i].precio+
                    "</td>";

                
                    opciones+= 
                    '<td style="text-align: center;">' +
                    data.partes_producciones[i].subtotal +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
            opciones+="<tr>"+
            "</td>" +
            '<td colspan="6" style="text-align: center;" class="table-danger" class="table-danger">' +
            total +
                " Bs" +
            "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        });
}






