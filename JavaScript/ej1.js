//NOMBRE DEL ALUMNO: Pedro Sánchez Fajardo

//RESOLUCIÓN DEL EXAMEN
(function() {
    
    document.addEventListener("DOMContentLoaded", main)

    function main() {
        const formMovimientos = document.querySelector("#formMovimientos")
        formMovimientos.action = "formOK.html"

        const anyadir = document.querySelector("#anyadir")
        anyadir.addEventListener("click", addItem)

        formMovimientos.addEventListener("submit", function(e) {
            e.preventDefault()

            if(todoOK())
                formMovimientos.submit()
        })

        const table = document.querySelector("table#tablaMovs")
        table.addEventListener("click", e => {
            if(e.target.classList.contains("botonBorrar")) {
                const cantidad = e.target.parentElement.parentElement.children[1].firstChild
                const numMovs = document.querySelector("#numMovs")
                const saldo = document.querySelector("#saldo")
                const tipo = document.querySelector("#tipo").value

                var cantidad_punto = cantidad.value.replace(/,/g, '.')
                saldo.setAttribute("value", saldo.value.replace(/,/g, '.'))

                numMovs.setAttribute("value", Number(numMovs.value) - 1)
                if(tipo == "a")
                    saldo.setAttribute("value", Number(saldo.value) - Number(cantidad_punto))
                else
                    saldo.setAttribute("value", Number(saldo.value) + Number(cantidad_punto))

                saldo.setAttribute("value", saldo.value.replace(/\./g, ','))

                e.target.parentElement.parentElement.remove()
            }
        })
    }

    function todoOK()
    {
        const conceptoError = document.querySelector("#conceptoError")
        const cantidadError = document.querySelector("#cantidadError")
        const tipoError = document.querySelector("#tipoError")

        conceptoError.textContent = ""
        cantidadError.textContent = ""
        tipoError.textContent = ""

        let todoOK = true

        if(!conceptoOK())
        {
            todoOK = false
            conceptoError.textContent = "Concepto incorrecto"
        }

        if(!cantidadOK())
        {
            todoOK = false
            cantidadError.textContent = "Cantidad incorrecta"
        }

        if(!tipoOK())
        {
            todoOK = false
            tipoError.textContent = "Tipo incorrecto"
        }

        return todoOK
    }

    function conceptoOK()
    {
        const concepto = document.querySelector("#concepto").value
        const conceptoPatron = /^[a-zA-Z0-9 -]{4,30}$/

        return conceptoPatron.test(concepto)
    }

    function cantidadOK()
    {
        const cantidad = document.querySelector("#cantidad").value
        const cantidadPatron = /^\d{1,},\d{2}$/

        return cantidadPatron.test(cantidad)
    }

    function tipoOK()
    {
        const tipo = document.querySelector("#tipo")

        return (tipo.value.length ? true : false)
    }

    function addItem() {
        const table = document.querySelector("#tablaMovs>tbody")
        
        if(todoOK()) {
            const concepto = document.querySelector("#concepto").value
            const cantidad = document.querySelector("#cantidad").value
            const tipo = document.querySelector("#tipo").value

            // Tengo que cambiar los puntos por comas para que la funcion Number me funcione
            var cantidad_punto = cantidad.replace(/,/g, '.')
            // Pongo el saldo con punto de nuevo para que se pueda sumar al añadir una nueva cantidad
            saldo.setAttribute("value", saldo.value.replace(/,/g, '.'))
            
            numMovs.setAttribute("value", Number(numMovs.value) + 1)
            if(tipo == "a")
                saldo.setAttribute("value", Number(saldo.value) + Number(cantidad_punto))
            else
                saldo.setAttribute("value", Number(saldo.value) - Number(cantidad_punto))

            // Pongo el saldo con coma para seguir con la estética del ejercicio
            saldo.setAttribute("value", saldo.value.replace(/\./g, ','))

            let nuevoTR = document.createElement("TR")
        
            let nuevoTD1 = document.createElement("TD")
            nuevoTD1.innerHTML = '<input type="text" value="" disabled>'
            nuevoTD1.firstChild.setAttribute("value", concepto)
    
            let nuevoTD2 = document.createElement("TD")
            nuevoTD2.innerHTML = '<input type="text" value="" disabled>'
            nuevoTD2.firstChild.setAttribute("value", cantidad)

            let nuevoTD3 = document.createElement("TD")
            nuevoTD3.innerHTML = '<input type="text" value="" disabled>'
            if(tipo == "p")
                nuevoTD3.firstChild.setAttribute("value", "Pago")
            else
            nuevoTD3.firstChild.setAttribute("value", "Ingreso")
    
            let nuevoTD4 = document.createElement("TD")
            nuevoTD4.innerHTML = '<input type="button" class="botonBorrar" value="Borrar">'

            nuevoTR.append(nuevoTD1, nuevoTD2, nuevoTD3, nuevoTD4)
            table.append(nuevoTR)
        }
    }

})();





