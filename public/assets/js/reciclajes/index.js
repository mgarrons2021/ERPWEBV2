/*ELIMINAR RECICLAJE*/
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
                        url: ruta_eliminarreciclaje + "/" + id,
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
                                        window.location = ruta_indexreciclaje;
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
