$(document).ready(function () {
    $("#proveedor_id").select2();
    $("#sucursal_id").select2();
});

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
$("#cerrar_modal2").on("click", () => {
    $("#exampleModal2").modal("close");
});
$("#cerrar_modal1").on("click", () => {
    $("#exampleModal1").modal("close");
});

$(document).ready(function () {
    $("#proveedor_id").select2({
        width: "resolve",
        dropdownParent: $("#exampleModal2"),
    });
    $("#sucursal_id").select2({
        width: "resolve",
        dropdownParent: $("#exampleModal2"),
    });
});

$("#table").DataTable({
    language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningun dato disponible en esta tabla",
        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
            sFirst: "Primero",
            sLast: "Ãšltimo",
            sNext: "Siguiente",
            sPrevious: "Anterior",
        },
        oAria: {
            sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
        },
    },
    columnDefs: [
        {
            orderable: false,
            targets: 7,
        },
    ],
});


let chekboxs = document.getElementsByClassName("custom-control checkboxs");
let inputs_numbers = document.getElementsByClassName("input-numbers");
let pagar = document.getElementById("pagar");
let pago = document.getElementById("pago");

/* pago.addEventListener('click',(e)=>{
    
}) */


/*ELIMINAR UNA COMPRA*/
function deleteItem(e) {
    let id = e.getAttribute("data-id");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: true,
    });
    swalWithBootstrapButtons
        .fire({
            title: "Esta seguro de que desea eliminar este registro?",
            text: "Este cambio no se puede revertir!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "No, Cancelar!",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.value) {
                if (result.isConfirmed) {
                    let id = e.getAttribute("data-id");
                    $.ajax({
                        type: "DELETE",
                        url: ruta_eliminarCompra + "/" + id,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (data) {
                            if (data.success) {
                                swalWithBootstrapButtons
                                    .fire(
                                        "Eliminado!",
                                        "El registro ha sido eliminado.",
                                        "success"
                                    )
                                    .then(function () {
                                        window.location = ruta_indexCompra;
                                    });
                            }
                        },
                    });
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    "Cancelado",
                    "No se registro la eliminación",
                    "error"
                );
            }
        });
}

pagar.addEventListener("click", (e) => {
   

    let input_pagos = [];
    let comprasid = [];
    let input_pagos1 = [];

    for (let i in chekboxs) {
        console.log(chekboxs[i]);
        if (chekboxs[i].checked == true) {
            comprasid.push(parseInt(chekboxs[i].value));
            input_pagos1.push(inputs_numbers[i].value);
        }
    }


   
    fetch(ruta_pago, {
        method: "POST",
        body: JSON.stringify({
            banco: $("#banco").val(),
            nro_cuenta: $("#nro_cuenta").val(),
            nro_comprobante: $("#nro_comprobante").val(),
            nro_cheque: $("#nro_cheque").val(),
            tipo_pago: $("#tipo_pago").val(),
            compras_id: comprasid,
            pagos: input_pagos1,
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
                window.location.href = ruta_indexCompra;
            }
        })
        .catch((error) => console.error(error));
    input_pagos = [];
});
