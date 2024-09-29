/**
 * 
 * @param {HTMLInputElement} input 
 */
function mudaSelecao(input) {
    let selecaoParent = input.closest('.selecao-um-dois');

    let formUm = selecaoParent.querySelector('.selecao-form-um');
    let formDois = selecaoParent.querySelector('.selecao-form-dois');

    if (input.value == 'form-um') {
        formUm.style.display = 'block';
        formDois.style.display = 'none';
    }

    if (input.value == 'form-dois') {
        formUm.style.display = 'none';
        formDois.style.display = 'block';
    }
}

document.addEventListener("DOMContentLoaded", () => {
    let inputs = document.querySelectorAll('.selecao-radio:checked');

    inputs.forEach((input) => {
        mudaSelecao(input);
    });
});