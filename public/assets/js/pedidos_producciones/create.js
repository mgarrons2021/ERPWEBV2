
let agregar_plato = document.getElementById("agregar_plato");

let guardar_pedido = document.getElementById("guardar_pedido");
let cancelar = document.getElementById("cancelar");


let plato = document.getElementById("plato");
let plato_nombre = document.getElementById("plato_nombre");
let costo = document.getElementById("precio");
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

    if(fecha.value==''){
        $("#errorfecha").removeClass("d-none");
    }

    if(fecha.value != ''){
        fetch(ruta_guardar_pedido, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
            body : JSON.stringify({
    
                "fecha_pedido" :fecha_pedido.value,
            })
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Pedido agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_pedidos;
                    },
                });
            }else{
                iziToast.warning({
                    title: "AVISO",
                    message: "Problemas al guardar el pedido",
                    position: "topRight",
                    timeout: 1500,
                    
                });

            }
        })
        .catch((error) => console.error(error));

    }else{
        iziToast.warning({
            title: "AVISO",
            message: "Debe seleccionar una fecha",
            position: "topCenter",
            timeout: 1500,
            
        });

    }
    

})






/*AGREGAR INSUMO DE PEDIDO*/

agregar_plato.addEventListener("click", (e) => {

    if (cantidad_solicitada.value == "") {
        $("#errorcantidad").removeClass("d-none");
    }else{
        $("#errorcantidad").addClass("d-none");
    }

    if (plato.value == "x") {
        $("#errorproducto").removeClass("d-none");
    }else{
        $("#errorproducto").addClass("d-none");
    }
    

    if( (cantidad_solicitada.value.length) >0 && plato.value!="x"){
        subtotal_solicitado.value= (cantidad_solicitada.value * precio.value).toFixed(3);
        fetch(ruta_agregar_plato, {
            method: "POST",
            body: JSON.stringify({
                detallePedidoProduccion: {
                    plato: plato.value,
                    plato_nombre: plato_nombre.value,
                    costo: precio.value,
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
            for (let i in data.pedidos_producciones) {
                total += parseFloat(
                    data.pedidos_producciones[i].subtotal_solicitado
                );
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.pedidos_producciones[i].plato_nombre +
                "</td>";
            
                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_producciones[i].cantidad_solicitada +
                    "</td>"; 
    
                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_producciones[i].costo +
                    "</td>";
    
                    opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_producciones[i].subtotal_solicitado +
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

/*Get Dish Cost */
/* plato.addEventListener("change", (e) => {
    
    fetch(ruta_obtener_costo, {
        method: "POST",
        body: JSON.stringify({
            plato_id: e.target.value,
            
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

            if(data.costo[0]!=null){
                console.log(data.costo[0].costo);
                document.getElementById("costo").value =data.costo[0].costo;
            }else{
                producto.selectedIndex=0;
                iziToast.warning({
                    title: "WARNING",
                    message: "El plato no cuenta con un Costo",
                    position: "topRight",
                    timeout: 1500,                    
                });
            }
            
            /* var opciones = '' ; */
            /* for (let i in data.lista) {
                opciones +=
                    '<option value="' +
                    data.lista[i].id +
                    '">' +
                    data.lista[i].nombre +
                    "</option>";
            } 
         
        })
        .catch((error) => console.error(error));
});
 */









/*Eliminar Insumo Agregado*/
function eliminar(i) {
    fetch(ruta_eliminar_plato, {
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
            for (let i in data.pedidos_producciones) {
                total += parseFloat(
                    data.pedidos_producciones[i].subtotal_solicitado
                );
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.pedidos_producciones[i].plato_nombre +
                "</td>";
            
                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_producciones[i].cantidad_solicitada +
                    "</td>";
                
                  

               

                opciones+= 
                    '<td style="text-align: center;">' +
                    data.pedidos_producciones[i].costo +
                    "</td>";

                
                    opciones+= 
                    '<td style="text-align: center;">' +
                    data.pedidos_producciones[i].subtotal_solicitado +
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

/* Calculo el sub total segun costo */

cantidad_solicitada.addEventListener("keyup", (e)=> {
    subtotal_solicitado.value= (cantidad_solicitada.value * costo.value).toFixed(3);
})


