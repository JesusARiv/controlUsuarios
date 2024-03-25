document.addEventListener('DOMContentLoaded', async () => {
    initUserTable();
});

const initUserTable = () => {
    userDT = $('#userTable').DataTable({
        serverSide: true,
        processing: true,
        searching: false,
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: route('filter'),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('#csrf').attr('content'),
                Accept: 'application/json'
            },
            data: d => {
                d.name = $('#name').val();
                d.email = $('#email').val();
                d.user_type = $('#user_type').val();
                return d;
            }
        },
        columns: [
            {
                data: 'name',
                defaultContent: '',
                render: data => data ?? ''
            },
            {
                data: 'email',
                defaultContent: '',
                render: data => data ?? ''
            },
            {
                data: 'user_type.type',
                defaultContent: '',
                render: data => data ?? ''
            },
            {
                data: 'id',
                defaultContent: '',
                render: function (id) {
                    return `
                    <button class="btn btn-warning" onclick="editModal(${id});"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn btn-danger" onclick="deleteUser(${id});"><i class="fa-solid fa-trash"></i></button>
                    `;
                }
            }
        ]
    });
};

const filter = () => {
    event.preventDefault();
    userDT.ajax.reload();
}

const restart = () => {
    event.preventDefault();
    userConfigForm.reset();
    userDT.ajax.reload();
}

const registerModal = async () => {
    event.preventDefault();
    const url = route('user.create');
    const init = setMethodHeaders('GET');
    const req = await fetch(url, init);
    if (req.ok) {
        const modal = new bootstrap.Modal(document.getElementById('modal'));
        const view = await req.text();
        // document.getElementById('modalSize').classList.add('modal-xl');
        document.getElementById('modalTitle').innerHTML = "Registrar usuario";
        document.getElementById('modalBody').innerHTML = view;
        modal.toggle();
    }
}

const register = async () => {
    event.preventDefault();
    Swal.fire({
        title: 'Registrando usuario',
        text: 'Espera un momento por favor...',
        didOpen: () => Swal.showLoading()
    });
    const registerForm = document.getElementById('registerForm');
    const url = route('user.store');
    const formData = new FormData(registerForm);
    const init = setMethodHeaders('POST', formData);

    try {
        const response = await fetch(url, init);

        if (response.ok) {
            Swal.close();
            // Usuario creado correctamente
            Swal.fire({
                title: 'Usuario creado',
                text: 'El usuario se ha creado correctamente.',
                icon: 'success',
                confirmButtonColor: "#145A32",
                confirmButtonText: "Aceptar",
            });
            $('.modal').modal('hide');
            userDT.ajax.reload();
        } else {
            Swal.close();
            // Error al crear usuario
            const errorData = await response.json();
            Swal.fire({
                title: 'Error al crear usuario',
                text: errorData.error || 'Hubo un problema al procesar la solicitud.',
                icon: 'error',
                confirmButtonColor: "#145A32",
                confirmButtonText: "Aceptar",
            });
        }
    } catch (error) {
        Swal.close();
        // Error de red u otra excepción
        console.error('Error al realizar la solicitud:', error);
        Swal.fire({
            title: 'Error de red',
            text: 'Hubo un problema al comunicarse con el servidor.',
            icon: 'error',
            confirmButtonColor: "#145A32",
            confirmButtonText: "Aceptar",
        });
    }
};

const editModal = async (id) => {
    event.preventDefault();
    const url = route('user.edit', id);
    const init = setMethodHeaders('GET');
    const req = await fetch(url, init);
    if (req.ok) {
        const modal = new bootstrap.Modal(document.getElementById('modal'));
        const view = await req.text();
        // document.getElementById('modalSize').classList.add('modal-xl');
        document.getElementById('modalTitle').innerHTML = "Editar usuario";
        document.getElementById('modalBody').innerHTML = view;
        modal.toggle();
    }
}

const editUser = async (id) => {
    event.preventDefault();
    Swal.fire({
        title: 'Actualizando datos',
        text: 'Espera un momento por favor...',
        didOpen: () => Swal.showLoading()
    });
    const editForm = document.getElementById('editForm');
    const url = route('user.update', id);
    const formData = new FormData(editForm);
    const init = setMethodHeaders('PUT', formData);

    try {
        const response = await fetch(url, init);

        if (response.ok) {
            Swal.close();
            // Datos editados correctamente
            Swal.fire({
                title: 'Datos editados',
                text: 'Los datos se han editado correctamente.',
                icon: 'success',
                confirmButtonColor: "#145A32",
                confirmButtonText: "Aceptar",
            });
            $('.modal').modal('hide');
            userDT.ajax.reload();
        } else {
            Swal.close();
            // Error al editar datos
            const errorData = await response.json();
            Swal.fire({
                title: 'Error al editar datos',
                text: errorData.error || 'Hubo un problema al procesar la solicitud.',
                icon: 'error',
                confirmButtonColor: "#145A32",
                confirmButtonText: "Aceptar",
            });
        }
    } catch (error) {
        Swal.close();
        // Error de red u otra excepción
        console.error('Error al realizar la solicitud:', error);
        Swal.fire({
            title: 'Error de red',
            text: 'Hubo un problema al comunicarse con el servidor.',
            icon: 'error',
            confirmButtonColor: "#145A32",
            confirmButtonText: "Aceptar",
        });
    }
}

const deleteUser = async (id) => {
    event.preventDefault();
    // Muestra un mensaje de carga mientras se procesa la eliminación
    Swal.fire({
        title: "¿Desea eliminar este usuario?",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "red",
        icon: 'warning'
    }).then(async(result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Borrando usuario',
                text: 'Espera un momento por favor...',
                didOpen: () => Swal.showLoading()
            });
            const url = route('user.destroy', id);
            const init = setMethodHeaders('DELETE');
            try {
                const response = await fetch(url, init);

                if (response.ok) {
                    // Usuario eliminado correctamente
                    Swal.fire({
                        title: 'Usuario eliminado',
                        text: 'El usuario se ha eliminado correctamente.',
                        icon: 'success',
                        confirmButtonColor: "#145A32",
                        confirmButtonText: "Aceptar",
                    });

                    userDT.ajax.reload();
                } else {
                    // Error al eliminar usuario
                    const errorData = await response.json();
                    Swal.fire({
                        title: 'Error al eliminar usuario',
                        text: errorData.error || 'Hubo un problema al procesar la solicitud.',
                        icon: 'error',
                        confirmButtonColor: "#145A32",
                        confirmButtonText: "Aceptar",
                    });
                }
            } catch (error) {
                // Error de red u otra excepción
                console.error('Error al realizar la solicitud:', error);
                Swal.fire({
                    title: 'Error de red',
                    text: 'Hubo un problema al comunicarse con el servidor.',
                    icon: 'error',
                    confirmButtonColor: "#145A32",
                    confirmButtonText: "Aceptar",
                });
            }
        }
    });
};
