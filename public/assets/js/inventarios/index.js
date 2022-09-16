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

/*ELIMINAR UN INVENTARIO*/
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
                        url: ruta_eliminarInventario + "/" + id,
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
                                        window.location = ruta_indexInventario;
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
