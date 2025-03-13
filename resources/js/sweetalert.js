import Swal from 'sweetalert2';

window.Swal = Swal;

document.addEventListener('DOMContentLoaded', function () {
    if (window.sweetalertConfig) {
        Swal.fire(window.sweetalertConfig);
    }
});

// Define una función global opcional
window.showAlert = function (config) {
    Swal.fire(config).then((result) => {
        if (result.isConfirmed && config.reload) {
            location.reload();
        }
    });
};