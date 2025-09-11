import 'flowbite';
import './bootstrap';
import Swal from 'sweetalert2';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', function() {
    const pinjamButtons = document.querySelectorAll('.pinjam-button');

    pinjamButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const bookId = this.dataset.bookId;
            document.getElementById('book_id').value = bookId;
        });
    });
});

window.showOverdueAlert = function(count) {
    Swal.fire({
        title: 'Peringatan!',
        text: 'Jumlah buku yang sudah waktunya dikembalikan: ' + count,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

Alpine.start();
