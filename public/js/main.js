document.addEventListener('DOMContentLoaded', () => {
    forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const clientHeight = e.submitter.clientHeight + 'px';
            const clientwidth = e.submitter.clientwidth + 'px';

            e.submitter.style = `pointer-events: none; height: ${clientHeight}; width: ${clientwidth}`;
            e.submitter.classList.add('disabled');

            let wrapper = document.createElement('div');
            wrapper.style = `position: relative; height: ${clientHeight}; width: ${clientwidth}`;

            let ico = document.createElement('i');
            ico.className = 'ico-spinner';

            wrapper.append(e.submitter.cloneNode(true));
            wrapper.append(ico);
            e.submitter.replaceWith(wrapper);
        });
    });
});