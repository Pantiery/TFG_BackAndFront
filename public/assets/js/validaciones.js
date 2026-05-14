function validarForm() {
    let nombre = document.getElementById("nombre").value.trim();
    let apellido1 = document.getElementById("apellido1").value.trim();
    let apellido2 = document.getElementById("apellido2").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;

    let patronNombreYApellidos = /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{0,24}$/;
    let patronEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let patronPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

    let nombreValido = patronNombreYApellidos.test(nombre);
    let resultado1 = document.getElementById("div1");

    if (!nombreValido) {
        resultado1.textContent = "El nombre debe tener entre 1 y 25 letras y comenzar con mayúscula.";
        resultado1.style.color = "red";
    } else {
        resultado1.textContent = "Nombre correcto.";
        resultado1.style.color = "green";
    }

    let apellido1Valido = patronNombreYApellidos.test(apellido1);
    let resultado2 = document.getElementById("div2");

    if (!apellido1Valido) {
        resultado2.textContent = "El primer apellido debe tener entre 1 y 25 letras y comenzar con mayúscula.";
        resultado2.style.color = "red";
    } else {
        resultado2.textContent = "Primer apellido correcto.";
        resultado2.style.color = "green";
    }

    let apellido2Valido = patronNombreYApellidos.test(apellido2);
    let resultado3 = document.getElementById("div3");

    if (apellido2 === "") {
        resultado3.textContent = "";
    } else if (!apellido2Valido) {
        resultado3.textContent = "El segundo apellido debe tener entre 1 y 25 letras y comenzar con mayúscula.";
        resultado3.style.color = "red";
    } else {
        resultado3.textContent = "Segundo apellido correcto.";
        resultado3.style.color = "green";
    }

    let emailValido = patronEmail.test(email);
    let resultado4 = document.getElementById("div4");

    if (!emailValido) {
        resultado4.textContent = "El email debe tener un formato correcto.";
        resultado4.style.color = "red";
    } else {
        resultado4.textContent = "Email correcto.";
        resultado4.style.color = "green";
    }

    let passwordValido = patronPassword.test(password);
    let resultado5 = document.getElementById("div5");

    if (!passwordValido) {
        resultado5.textContent = "La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
        resultado5.style.color = "red";
    } else {
        resultado5.textContent = "Contraseña correcta.";
        resultado5.style.color = "green";
    }

    return (
        nombreValido &&
        apellido1Valido &&
        (apellido2 === "" || apellido2Valido) &&
        emailValido &&
        passwordValido
    );
}