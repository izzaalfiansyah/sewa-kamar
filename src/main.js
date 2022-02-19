import Swal from 'sweetalert2';

export const notif = (message, type, toast = false) => {
    if (toast) {
        const Mixin = Swal.mixin({
            toast: true,
            timer: 3000,
            timerProgressBar: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true
        });

        return Mixin.fire({
            title: message,
            icon: type
        });
    } else {
        return Swal.fire({
            title: type[0].toUpperCase() + type.slice(1),
            text: message,
            icon: type
        });
    }
}

export const readFile = (selector, callback) => {
    const file = document.querySelector(selector).files[0];
    var reader = new FileReader();
    reader.onload = () => {
        callback(reader.result);
    }
    reader.readAsDataURL(file);
}