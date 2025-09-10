import 'flowbite';
import './bootstrap';

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

Alpine.start();
