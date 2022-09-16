
let agregar_plato = document.getElementById("agregar_plato");
let guardar_menu = document.getElementById("guardar_menu");
let cancelar = document.getElementById("cancelar");


let plato = document.getElementById("plato");
let dia = document.getElementById("dia");
let plato_nombre = document.getElementById("plato_nombre"); 
let categoria_plato = document.getElementById("categoria_plato");




const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_menu_index;
});

/* Guardar Los Platos Agregados */

guardar_menu.addEventListener("click", (e)=>{ 
    fetch(ruta_guardar_menu, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
        body : JSON.stringify({

            "fecha" :fecha.value,
            "dia":dia.value,
        })
    })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Menu agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_menu_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));

})


/*AGREGAR Plato Menu semanal*/

agregar_plato.addEventListener("click", (e) => {
    fetch(ruta_agregar_plato, {
        method: "POST",
        body: JSON.stringify({
            detalleMenu: {
                plato: plato.value,
                plato_nombre: plato_nombre.value,
                dia:dia.value,
                categoria_plato: categoria_plato.value,
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
            
            var opciones = "";
            for (let i in data.menus_semanales) {
              
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.menus_semanales[i].dia +
                "</td>";

                opciones +=
                '<td style="text-align: center;">' +
                data.menus_semanales[i].plato_nombre +
                "</td>";

                opciones +=
                '<td style="text-align: center;">' +
                data.menus_semanales[i].categoria_plato +
                "</td>";


                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
            
            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));

});





/*Eliminar Plato Agregado*/
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
            
            var opciones = "";
            for (let i in data.menus_semanales) {
              
                opciones += "<tr>";
                
                opciones +=
                '<td style="text-align: center;">' +
                data.menus_semanales[i].dia +
                "</td>";

                opciones +=
                '<td style="text-align: center;">' +
                data.menus_semanales[i].plato_nombre +
                "</td>";
                opciones +=
                '<td style="text-align: center;">' +
                data.menus_semanales[i].categoria_plato +
                "</td>";


                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
           

            document.getElementById("tbody").innerHTML = opciones;
        });
}


