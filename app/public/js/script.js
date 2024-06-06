document.addEventListener("DOMContentLoaded", function () {

    var showRegisterLink = document.getElementById("showRegister");

    var registerForm = document.getElementById("registerForm");

    var loginForm = document.getElementById("loginForm");



    showRegisterLink.addEventListener("click", function (event) {

        event.preventDefault();

        if (registerForm.style.display === "none") {

            registerForm.style.display = "block";

            loginForm.style.display = "none"; // Ocultar formulario de inicio de sesión

        } else {

            registerForm.style.display = "none";

            loginForm.style.display = "block"; // Mostrar formulario de inicio de sesión

        }

    });

});



function togglePasswordVisibility(icon) {

    var input = icon.previousElementSibling;

    if (input.type === "password") {

        input.type = "text";

        icon.classList.remove('fa-eye-slash');

        icon.classList.add('fa-eye');

    } else {

        input.type = "password";

        icon.classList.remove('fa-eye');

        icon.classList.add('fa-eye-slash');

    }

}


// Script de cliente

$(document).ready(function() {

    $("#loginForm").submit(function(event) {

        event.preventDefault(); // Evitar que se envíe el formulario de forma predeterminada

        

        // Obtener los valores del formulario

        var correoElectronico = $("#correo_electronico").val();

        var contrasena = $("#contrasena").val();

        

        // Enviar los datos al servidor mediante AJAX

        $.ajax({

            type: "POST",

            url: "Controllers/UserController.php", // Ruta al controlador que maneja el inicio de sesión

            data: {

                correo_electronico: correoElectronico,

                contrasena: contrasena

            },

            dataType: "json",

            success: function(response) {

                if (response.success) {

                    // Redirigir a la página principal si el inicio de sesión es exitoso

                    window.location.href = "main.php";

                } else {

                    // Mostrar mensaje de error si las credenciales son inválidas

                    $("#mensaje-error").text(response.message);

                }

            }

        });

    });

});

