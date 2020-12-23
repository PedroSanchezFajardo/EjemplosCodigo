//NOMBRE DEL ALUMNO: Pedro Sánchez Fajardo

//RESOLUCIÓN DEL EJERCICIO 2 DEL EXAMEN
(function() {
    let colorear
    const numCeldas = 60
    const milisegundos = 100

    document.addEventListener("DOMContentLoaded", main)

    function main() {
        const segundos = document.querySelector("#segundos>tbody")

        var i
        for (i = 0; i < numCeldas; i++) {
            let celda = document.createElement("td")
            segundos.append(celda)
        }
        
        const empezar = document.querySelector("#empezar")
        empezar.addEventListener("click", comenzarSegundos)

        
        const parar = document.querySelector("#parar")
        parar.addEventListener("click", function() {
            // Se para el intervalo
            clearInterval(colorear)
            // Como se ha ejecutado el botón de parar, vuelvo a darle el EventListener al boton de empezar
            empezar.addEventListener("click", comenzarSegundos)
            // Reicio del color de las celdas
            const celdas = document.querySelectorAll("#segundos td")
            celdas.forEach(celda => {
                if(celda.classList == "coloreado")
                    celda.classList.remove("coloreado")
            })
        })
    }

    function comenzarSegundos()
    {
        // Evitar que el usuario vuelva a hacer click sobre el botón comenzar
        empezar.removeEventListener("click", comenzarSegundos)
        
        const celdas = document.querySelectorAll("#segundos td")
        
        var contador = 0

        colorear = setInterval(function() {
            celdas[contador].classList.toggle("coloreado")
            contador++

            if(contador == numCeldas)
                contador = 0
        }, milisegundos)
    }

})();