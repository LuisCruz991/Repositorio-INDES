
// se declara la constante del formulario donde se introduce el codigo 
const CODE_FORM = document.getElementById('code-form');

// se declara la constante del form de recuperacion 
const RECU_FORM = document.getElementById('recu-form');


const chara1 = Math.random().toString(36).substring(2, 3); // se declara el primer valor del codigo
const chara2 = Math.random().toString(36).substring(2, 3); // se declara el segundo valor del codigo
const chara3 = Math.random().toString(36).substring(2, 3); // se declara el tercer valor del codigo
const chara4 = Math.random().toString(36).substring(2, 3); // se declara el cuarto valor del codigo


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

    // Metodo para validar que no hayan campos vacios 
    if (value1 != "" && value2 != "" && value3 != "" && value4 != "") {

        // array donde se almacenan los characteres ingresados 
        const CODE = new Array (chara1, chara2, chara3, chara4);
        let character = CODE.toString(); // Convertimos el array del codigo a string
        const DATA = new Array (value1, value2, value3, value4); // se guardan los characteres ingresados en un array
        let input = DATA.toString(); // el array lo convertimos a string
        // Metodo para comprobar que los dos codigos coincidan 
        if (character == input) {
            // En caso de coincidir se imprime un mensaje y se redirecciona al usuario al formulario de restablecer contraseña
            sweetAlert(1, 'Autenticación completada exitosamente', true, 'index.html');
        }
        else {
            // En caso de no coincidir se imprime un mensaje de error 
            sweetAlert(2, 'El código que has introducido no coincide con el enviado', false); // Mostrar un mensaje de error.
            // se limpian los campos en caso de error 
            // var value1 = document.getElementById('c1').value = '';
            // var value2 = document.getElementById('c2').value = '';
            // var value3 = document.getElementById('c3').value = '';
            // var value4 = document.getElementById('c4').value = '';
        }
    }
    else {
    }
})




// Funcion para abrir el reporte de las horas cumplidas de entrenamiento de un atleta
function openMail(name,code) {
    // varible donde se almacenan los characteres del codigo 
    code = chara1 + chara2 + chara3 + chara4 ;

    name = document.getElementById('nombres').value ;
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}mails/recu.php`);
    //
    PATH.searchParams.append('codigo',code);
    //
    PATH.searchParams.append('nombre_usuario',name);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}





