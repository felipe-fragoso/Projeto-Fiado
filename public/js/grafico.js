document.addEventListener('DOMContentLoaded', function () {
    let graficoBarras = document.querySelectorAll('.grafico-barra');

    graficoBarras.forEach(grafico => {
        let barras = grafico.querySelectorAll('.g-barra');
        let maxValue = 1;


        barras.forEach(barra => {
            let valor = parseInt(barra.querySelector('.g-barra-valor').textContent);

            if (valor > maxValue) {
                maxValue = valor;
            }
        });

        barras.forEach(barra => {
            let valor = parseInt(barra.querySelector('.g-barra-valor').textContent);
            let height = valor / maxValue;

            barra.style.height = (barra.clientHeight * height) + "px";
        })
    });
});