let timer = null;

document.addEventListener("DOMContentLoaded", () => {
    let selects = document.querySelectorAll('.select-searchable');

    selects.forEach((select) => {
        let selectId = select.id;
        select.removeAttribute('id');
        let idList = 'list-' + selectId;

        let parent = select.parentNode;
        let wrapper = document.createElement('div');

        parent.replaceChild(wrapper, select);
        wrapper.appendChild(select);

        select.style.display = 'none';
        wrapper.classList.add('selectable-wrapper');

        let input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.id = selectId;
        input.setAttribute('list', idList);
        input.setAttribute('placeholder', select.options[0].text);

        input.addEventListener('input', (e) => {
            verifyInsert(select, e.target.value);
        });

        input.addEventListener('blur', (e) => {
            selectUpdate(select, e.target.value);

            if (select.options.selectedIndex == 0) {
                e.target.value = '';
            } else {
                e.target.setAttribute('disabled', true);
                button = document.createElement('button');
                button.innerHTML = 'Mudar';
                button.setAttribute('type', 'button');
                button.setAttribute('onClick', 'mudarValor(this)')

                wrapper.appendChild(button);
            }
        });

        let list = document.createElement('datalist');
        list.id = idList;

        for (let i = 1; i < select.options.length; i++) {
            list.appendChild(new Option('', select.options[i].text));
        }

        wrapper.appendChild(input);
        wrapper.appendChild(list);
    });
})

function selectUpdate(select, value) {
    let validInsert = false;
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].text == value) {
            select.options.selectedIndex = i;
            validInsert = true;
        }
    }

    if (!validInsert) {
        select.options.selectedIndex = 0;
    }
}

function verifyInsert(select, value) {
    clearTimeout(timer);

    timer = setTimeout(() => { selectUpdate(select, value) }, 700);
}

function mudarValor(button) {
    wrapper = button.parentNode;
    wrapper.removeChild(button);
    input = wrapper.querySelector('input')

    input.removeAttribute('disabled');
    input.focus();
}