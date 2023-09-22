// constante con el link del archivo de php
const RECU = '../api/mails/recu.php';

// Constante para completar la ruta de la API.
const USUARIO_API = 'business/usuario.php';

// se declara la constante del formulario donde se introduce el codigo 
const CODE_FORM = document.getElementById('code-form');

// se declara la constante del form de recuperacion 
const RECU_FORM = document.getElementById('recu-form');

// variable donde se guardara el codigo 
let code = null;

//Constante del div donde se introduce el codigo
const CODE_I = document.getElementById('code_form');

//Constante del div donde se introduce el codigo
const CONTRA = new Modal(document.getElementById('contra-modal'));

//Constante del div donde se introduce el codigo
const CONTRA_FORM = document.getElementById('contra-form');

// Evento cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
});

// Evento para mandar el codigo al correo correo 
RECU_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
})

//  Evento para validar el codigo enviado 
CODE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
    // Variables para obtener los valores de los inputs 
    var value1 = document.getElementById('c1').value;
    var value2 = document.getElementById('c2').value;
    var value3 = document.getElementById('c3').value;
    var value4 = document.getElementById('c4').value;
    var value5 = document.getElementById('c5').value;
    var value6 = document.getElementById('c6').value;
    var value7 = document.getElementById('c7').value;
    var value8 = document.getElementById('c8').value;


    // Metodo para validar que no hayan campos vacios 
    if (value1 != "" && value2 != "" && value3 != "" && value4 != "" && value5 != "" && value6 != "" && value7 != "" && value8 != "") {
        const DATA = value1 + value2 + value3 + value4 + value5 + value6 + value7 + value8; // se guardan los characteres ingresados en una constante
        // Metodo para comprobar que los dos codigos coincidan 
        if (code == DATA) {
            // En caso de coincidir se imprime un mensaje y se redirecciona al usuario al formulario de restablecer contraseña
            sweetAlert(1, 'Autenticación completada exitosamente');
            // se muestra el modalr para hacer el cambio de contraseña
            CONTRA.show();
            // se obtiane el valor del usuario 
            document.getElementById('nombre').value = document.getElementById('nombres').value;
        }
        else {
            // En caso de no coincidir se imprime un mensaje de error 
            sweetAlert(2, 'El código que has introducido no coincide con el enviado', false); // Mostrar un mensaje de error.
        }
    }
    else {
    }
})

// evento para cuando se manda el formulario del cambio de contraseña
CONTRA_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar recargar la página web después de enviar el formulario.
    const FORM = new FormData(CONTRA_FORM);
    // se ejecuta la accion del business
    const JSON = await dataFetch(USUARIO_API, 'recuPassword',FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
      // Se muestra un mensaje de éxito.
      sweetAlert(1, JSON.message, true, 'index.html'); // Mostrar mensaje de éxito y redirigir a la página de inicio.
    } else {
      sweetAlert(2, JSON.exception, false); // Mostrar mensaje de error en tal caso
    }
})

// Funcion para abrir el reporte de las horas cumplidas de entrenamiento de un atleta
function openMail() {
    // se valida que el campo no está vacio 
    if (document.getElementById('nombres').value != "") {
        //se ejecuta la sentencia de el php con el paraetro del nombre de usuario
        fetch(`${RECU}?nombre_usuario=${document.getElementById('nombres').value}`).then(response => response.json())
            .then(data => {
                //se le asigna el valor del codigo a una variable
                code = data.code;
                // se muestra el formulario del codigo
                CODE_I.classList.remove('hidden');
                // se obtiene el formulario del usuario
                var usuario = document.getElementById('usuario_form');
                // se obtiene el boton de regreso
                var back = document.getElementById('back');
                // se muestra el formulario del codigo
                back.classList.remove('hidden');
                //se oculta el formulario del usuario
                usuario.classList.add('hidden');
            }).catch(error => {
                //se imprime un mensaje de error en tal caso
                console.error('Ha ocurrido un error al ejecutar el codigo', error);
                // se imprime un mensaje de error
                sweetAlert(2, 'El usuario que haz introducido no existe', false); // Mostrar un mensaje de error.
            });
    } else {
        // se imprime un mensaje de error 
        sweetAlert(2, 'Por favor introduce un nombre de usuario valido', false); // Mostrar un mensaje de error.
    }
}

// funcion para regresar al anterior formulario 
function Back() {
    // se oculta el formulario del codigo
    CODE_I.classList.add('hidden');
    // se obtine el formulario del usuario
    var usuario = document.getElementById('usuario_form');
    // se obtine el boton de regresar
    var back = document.getElementById('back');
    // se oculta el boton de regresar
    back.classList.add('hidden');
    // se muestra el formulario del usuario
    usuario.classList.remove('hidden');
}






