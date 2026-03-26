function validarForm() {
    let nombre = document.getElementById("nombre").value;
    let apellido1 = document.getElementById("apellido1").value;
    let apellido2 = document.getElementById("apellido2").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    // Expresiones regulares
    //nombre
    let patronNombreYApellidos = /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{0,24}$/;
    
    let nombreValido = patronNombreYApellidos.test(nombre);
    
    let resultado1 = document.getElementById("div1");
    
    if (!nombreValido) {
        resultado1.textContent = "El nombre debe tener entre 1 y 25 letras y comenzar con mayúscula.";
        resultado1.style.color = "red";
    }else{
        resultado1.textContent = "Nombre correcto.";
        resultado1.style.color = "green";
    }
    //apellido 1
    let apellido1Valido = patronNombreYApellidos.test(apellido1);
    
    let resultado2 = document.getElementById("div2");
    
    if (!apellido1Valido) {
        resultado2.textContent = "El primer apellido debe tener entre 1 y 25 letras y comenzar con mayúscula.";
        resultado2.style.color = "red";
    }else{
        resultado2.textContent = "Primer apellido correcto.";
        resultado2.style.color = "green";
    }
    //apellido 2
    let apellido2Valido = patronNombreYApellidos.test(apellido2);

    let resultado3 = document.getElementById("div3");
    
    if (apellido2 !== "" && !apellido2Valido) {
        resultado3.textContent = "El segundo apellido debe tener entre 1 y 25 letras y comenzar con mayúscula.";
        resultado3.style.color = "red";
    }else{
        resultado3.textContent = "Segundo apellido correcto.";
        resultado3.style.color = "green";
    }
    //email
    let patronEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    let emailValido = patronEmail.test(email);
    
    let resultado4 = document.getElementById("div4");
    
    if (!emailValido) {
        resultado4.textContent = "El email debe tener un formato correcto.";
        resultado4.style.color = "red";
    }else{
        resultado4.textContent = "Email correcto.";
        resultado4.style.color = "green";
    }
    //password
    let patronPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

    let passwordValido = patronPassword.test(password);

    let resultado5 = document.getElementById("div5");

    if (!passwordValido) {
        resultado5.textContent = "El email debe 8 caracteres, una mayúscula, un número y un caracter especial.";
        resultado5.style.color = "red";
    }else{
        resultado5.textContent = "Contraseña correcto.";
        resultado5.style.color = "green";
    }
    
    if (nombreValido && apellido1Valido && apellido2Valido && emailValido && passwordValido) {
        return true;
    }
    
    
    return false;
}