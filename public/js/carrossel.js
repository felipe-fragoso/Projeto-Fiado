/**
 * 
 * @param {HTMLLinkElement} link 
 * @returns {HTMLDivElement}
 */
function getCarrosselItems(link) {
    return link.parentNode.querySelector('.carrossel-items')
}

/**
 * 
 * @param {HTMLLinkElement} link 
 */
function carrossel(link) {
    var scrollLeft = true;

    if (link.classList.contains('carrossel-right')) {
        scrollLeft = false;
    }

    let carrosselItems = getCarrosselItems(link);

    if (scrollLeft) {
        carrosselItems.scrollTo({ left: carrosselItems.scrollLeft - 200, behavior: 'smooth' });
    } else {
        carrosselItems.scrollTo({ left: carrosselItems.scrollLeft + 200, behavior: 'smooth' });
    }
}
/**
 * 
 * @param {HTMLDivElement} carrosselBox 
 */
function checkLeftRightCarrossel(carrosselBox) {
    let leftButton = carrosselBox.parentNode.querySelector('.carrossel-left');
    let rightButton = carrosselBox.parentNode.querySelector('.carrossel-right');
    let maxScroll = carrosselBox.scrollWidth - carrosselBox.clientWidth;

    if (carrosselBox.scrollLeft == 0) {
        leftButton.classList.add('carrossel-disabled');
    } else {
        leftButton.classList.remove('carrossel-disabled');
    }

    if (carrosselBox.scrollLeft == maxScroll) {
        rightButton.classList.add('carrossel-disabled');
    } else {
        rightButton.classList.remove('carrossel-disabled');
    }
}

/**
 * Verificar se carrossel scroll
 */
document.addEventListener('DOMContentLoaded', function () {
    let carrosselsItems = document.querySelectorAll('.carrossel-items');

    carrosselsItems.forEach(function (carrosselBox) {
        carrosselBox.onscroll = () => checkLeftRightCarrossel(carrosselBox);
        checkLeftRightCarrossel(carrosselBox);
    });
}, false);
