document.addEventListener("DOMContentLoaded", function () {
    const registrationForm = document.getElementById("registrationForm");

    registrationForm.addEventListener("submit", function (event) {
        event.preventDefault();

        // Obtener datos del formulario
        const formData = new FormData(registrationForm);

        // Enviar datos al archivo PHP usando Fetch
        fetch("DatabaseRegistro.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.text())
            .then(message => {
                // Mostrar mensaje de éxito o error
                document.getElementById("mensajeRegistro").innerHTML = message;
            })
            .catch(error => console.error("Error al enviar datos: ", error));
    });
});