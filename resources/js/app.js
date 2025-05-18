import './bootstrap';

window.confirmDelete = function (id) {
    Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá reverter isso!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
        cancelButtonAriaLabel: "Cancelar",
        confirmButtonAriaLabel: "Excluir"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}