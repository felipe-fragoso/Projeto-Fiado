function showModal(id) {
    let modal = document.getElementById(id);

    setModal(modal);

    modal.style.display = 'block';
    document.body.classList.add('fixed');
}

/**
 * 
 * @param {HTMLDivElement} modal 
 */
function setModal(modal) {
    modal.addEventListener('click', (e) => {
        if (e.target !== modal) {
            return;
        }

        e.stopPropagation();

        modal.style.display = 'none';
        document.body.classList.remove('fixed');

        modal.removeEventListener('click', null);
    });
}

/**
 * 
 * @param {HTMLDivElement} modal 
*/
function closeModal(modal) {
    modal.style.display = 'none';
    document.body.classList.remove('fixed');

    modal.removeEventListener('click', null);
}