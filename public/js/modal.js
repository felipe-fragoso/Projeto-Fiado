function showModal(id) {
    let modal = document.getElementById(id);

    setModal(modal);

    modal.style.display = 'block';
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

        modal.removeEventListener('click', null);
    });
}