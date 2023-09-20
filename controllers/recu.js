
// constante con el link del archivo de php
const RECU = '../api/mails/recu.php';

// se declara la constante del formulario donde se introduce el codigo 
const CODE_FORM = document.getElementById('code-form');

// se declara la constante del form de recuperacion 
const RECU_FORM = document.getElementById('recu-form');

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


    // constante del codigo de verificacion 
    const CODE = document.getElementById('code').value ;
    // Metodo para validar que no hayan campos vacios 
    if (value1 != "" && value2 != "" && value3 != "" && value4 != "" && value5 != "" && value6 != "" && value7 != "" && value8 != "") {
        const DATA = value1 + value2 + value3 + value4 + value5 + value6 + value7 +value8 ; // se guardan los characteres ingresados en una constante
        // Metodo para comprobar que los dos codigos coincidan 
        if (CODE == DATA) {
            // En caso de coincidir se imprime un mensaje y se redirecciona al usuario al formulario de restablecer contraseña
            sweetAlert(1, 'Autenticación completada exitosamente', true, 'index.html');
        }
        else {
            // En caso de no coincidir se imprime un mensaje de error 
            sweetAlert(2, 'El código que has introducido no coincide con el enviado', false); // Mostrar un mensaje de error.
        }
    }
    else {
    }
})


// Funcion para abrir el reporte de las horas cumplidas de entrenamiento de un atleta
function openMail() {
    //se ejecuta la sentencia de el php con el paraetro del nombre de usuario
    fetch(`${RECU}?nombre_usuario=${document.getElementById('nombres').value}`).then(response => response.json())
    .then(data => {
        //se le asigna el codigo al campor del codigo
        document.getElementById('code').value = data.code;
    }).catch(error => {
        //se imprime un mensaje de error en tal caso
        console.error('Ha ocurrido un error al ejecutar el codigo', error);
    });

}







