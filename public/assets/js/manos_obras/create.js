
let agregar_funcionario = document.getElementById("agregar_funcionario");

let fecha= document.getElementById("fecha");
let ventas= document.getElementById("ventas");
let usuario= document.getElementById("usuario");
let user_name= document.getElementById("user_name");
let cantidad_horas= document.getElementById("cantidad_horas");
let subtotal_horas = document.getElementById("subtotal_horas");
let subtotal_costo = document.getElementById("subtotal_costo");

let registrar_mano_obra = document.getElementById("registrar_mano_obra");


let cancelar = document.getElementById("cancelar");




const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_pedidos;
});

/* Guardar Mano Obra */

registrar_mano_obra.addEventListener("click", (e)=>{ 
        fetch(ruta_guardar_mano_obra, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
            body: JSON.stringify({
                fecha: fecha.value,
                ventas: ventas.value,
            }),
           
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Mano Obra Registrado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_manos_obras;
                    },
                });
           
     
    }
    

})
});


/*AGREGAR FUNCIONARIO */

agregar_funcionario.addEventListener("click", (e) => {

    
    if (cantidad_horas.value == "") {
        $("#errorcantidad").removeClass("d-none");
    }else{
        $("#errorcantidad").addClass("d-none");
    }

    if (usuario.value == "x") {
        $("#errorproducto").removeClass("d-none");
    }else{
        $("#errorproducto").addClass("d-none");
    }
    

    if( (cantidad_horas.value.length) >0 && usuario.value!="x"){
       /*  subtotal_costo.value= (cantidad_horas.value * 8,84).toFixed(3); */
        fetch(ruta_agregar_funcionario, {
            method: "POST",
            body: JSON.stringify({
                detalleManoObra: {
                    usuario: usuario.value,
                    user_name: user_name.value,
                    cantidad_horas: cantidad_horas.value,
                    subtotal_horas: subtotal_horas.value,
                    subtotal_costo: subtotal_costo.value,
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
            
            let total_horas =0;
            let total_costo =0;
            
            var opciones = "";
            console.log(data);
            for (let i in data.manos_obras_sucursales) {
               
                total_horas += parseFloat(data.manos_obras_sucursales[i].cantidad_horas);
                total_costo += parseFloat(data.manos_obras_sucursales[i].subtotal_costo);

                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.manos_obras_sucursales[i].user_name +
                "</td>";
            
                opciones +=
                    '<td style="text-align: center;">' +
                    data.manos_obras_sucursales[i].cantidad_horas + "Hrs"+
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
            '<td colspan="5" style="text-align: center;" class="table-info">' +
            total_horas +
                " Hrs" +
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






/*Eliminar Funcionario Agregado*/
function eliminar(i) {
    fetch(ruta_eliminar_funcionario, {
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
            let total_horas =0;
            let total_costo =0;
            
            var opciones = "";
            for (let i in data.manos_obras_sucursales) {
                total_horas += parseFloat(data.manos_obras_sucursales[i].cantidad_horas);
                total_costo += parseFloat(data.manos_obras_sucursales[i].subtotal_costo);

                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.manos_obras_sucursales[i].user_name +
                "</td>";
            
                opciones +=
                    '<td style="text-align: center;">' +
                    data.manos_obras_sucursales[i].cantidad_horas + "Hrs"+
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
            '<td colspan="5" style="text-align: center;" class="table-info">' +
            total_horas +
                " Hrs" +
            "</tr>";


            document.getElementById("tbody").innerHTML = opciones;
        });
}






