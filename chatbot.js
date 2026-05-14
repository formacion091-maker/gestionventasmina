const telefonoTienda = '573232825032';
const nequiNumero = '3225869899';
const nequiNombre = 'josselin maria';

const estadoPedido = {
    producto: '',
    categoria: '',
    precio: '',
    descripcionProducto: '',
    nombre: '',
    telefono: '',
    direccion: '',
    descripcion: '',
    metodoPago: '',
    tipoCuenta: '',
    referenciaPago: ''
};

const pasosBase = [
    {
        campo: 'nombre',
        pregunta: 'Perfecto. Para concretar la compra, dime tu nombre completo.'
    },
    {
        campo: 'telefono',
        pregunta: 'Ahora dime tu numero de telefono.'
    },
    {
        campo: 'direccion',
        pregunta: 'Indica la direccion donde se debe llevar el producto.'
    },
    {
        campo: 'descripcion',
        pregunta: 'Agrega una descripcion: talla, color, cantidad o cualquier detalle importante.'
    }
];

let pasoActual = 0;
let modoPago = false;
let esperandoTipoCuenta = false;
let esperandoReferencia = false;

const chatbot = document.querySelector('.chatbot');
const botonChat = document.querySelector('.chatbot-boton');
const botonCerrar = document.querySelector('.chatbot-cerrar');
const mensajes = document.querySelector('.chatbot-mensajes');
const formulario = document.querySelector('.chatbot-form');
const input = document.querySelector('.chatbot-input');

function abrirChat(){
    chatbot.classList.add('chatbot-abierto');
    botonChat.classList.add('chatbot-boton-oculto');
    input.focus();
}

function cerrarChat(){
    chatbot.classList.remove('chatbot-abierto');
    botonChat.classList.remove('chatbot-boton-oculto');
}

function agregarMensaje(texto, tipo = 'bot'){
    const burbuja = document.createElement('div');
    burbuja.className = `chatbot-mensaje chatbot-${tipo}`;
    burbuja.textContent = texto;
    mensajes.appendChild(burbuja);
    mensajes.scrollTop = mensajes.scrollHeight;
}

function agregarOpciones(opciones){
    const grupo = document.createElement('div');
    grupo.className = 'chatbot-opciones';

    opciones.forEach((opcion) => {
        const boton = document.createElement('button');
        boton.type = 'button';
        boton.className = 'chatbot-opcion';
        boton.textContent = opcion.texto;
        boton.addEventListener('click', opcion.accion);
        grupo.appendChild(boton);
    });

    mensajes.appendChild(grupo);
    mensajes.scrollTop = mensajes.scrollHeight;
}

function reiniciarPedido(){
    pasoActual = 0;
    modoPago = false;
    esperandoTipoCuenta = false;
    esperandoReferencia = false;
    estadoPedido.nombre = '';
    estadoPedido.telefono = '';
    estadoPedido.direccion = '';
    estadoPedido.descripcion = '';
    estadoPedido.metodoPago = '';
    estadoPedido.tipoCuenta = '';
    estadoPedido.referenciaPago = '';
}

function iniciarCompra(datos){
    reiniciarPedido();
    estadoPedido.producto = datos.producto || 'Producto sin nombre';
    estadoPedido.categoria = datos.categoria || 'Sin categoria';
    estadoPedido.precio = datos.precio || 'Consultar precio';
    estadoPedido.descripcionProducto = datos.descripcion || '';

    mensajes.innerHTML = '';
    abrirChat();
    agregarMensaje(`Hola, soy el asistente de la tienda. Vamos a concretar la compra de: ${estadoPedido.producto}.`);
    agregarMensaje(pasosBase[pasoActual].pregunta);
}

function pedirMetodoPago(){
    modoPago = true;
    agregarMensaje('Elige por donde quieres pagar.');
    agregarOpciones([
        {
            texto: 'Pagar por Nequi',
            accion: seleccionarNequi
        },
        {
            texto: 'Pagar por cuenta bancaria',
            accion: seleccionarCuenta
        }
    ]);
}

function seleccionarNequi(){
    estadoPedido.metodoPago = 'Nequi';
    estadoPedido.tipoCuenta = 'Nequi';
    esperandoReferencia = true;
    agregarMensaje('Pagar por Nequi', 'cliente');
    agregarMensaje(`Datos de pago Nequi:\nNumero: ${nequiNumero}\nNombre: ${nequiNombre}`);
    agregarMensaje('Cuando hagas el pago, escribe aqui el numero de referencia o "pendiente" si lo pagaras despues.');
    input.focus();
}

function seleccionarCuenta(){
    estadoPedido.metodoPago = 'Cuenta bancaria';
    esperandoTipoCuenta = true;
    agregarMensaje('Pagar por cuenta bancaria', 'cliente');
    agregarMensaje('Selecciona el tipo de cuenta para registrar el pedido. Por seguridad no escribas el numero completo de una tarjeta en este chat.');
    agregarOpciones([
        {
            texto: 'Cuenta de ahorro',
            accion: () => seleccionarTipoCuenta('Cuenta de ahorro')
        },
        {
            texto: 'Cuenta de credito',
            accion: () => seleccionarTipoCuenta('Cuenta de credito')
        }
    ]);
}

function seleccionarTipoCuenta(tipo){
    estadoPedido.tipoCuenta = tipo;
    esperandoTipoCuenta = false;
    esperandoReferencia = true;
    agregarMensaje(tipo, 'cliente');
    agregarMensaje('Escribe la referencia del pago, los ultimos 4 digitos o "pendiente". No ingreses el numero completo de la tarjeta.');
    input.focus();
}

function crearMensajeWhatsApp(){
    const texto = [
        'Venta concretada en la tienda',
        `Producto: ${estadoPedido.producto}`,
        `Categoria: ${estadoPedido.categoria}`,
        `Precio: ${estadoPedido.precio}`,
        `Descripcion del producto: ${estadoPedido.descripcionProducto}`,
        `Cliente: ${estadoPedido.nombre}`,
        `Telefono del cliente: ${estadoPedido.telefono}`,
        `Direccion de entrega: ${estadoPedido.direccion}`,
        `Descripcion del pedido: ${estadoPedido.descripcion}`,
        `Metodo de pago: ${estadoPedido.metodoPago}`,
        `Tipo de cuenta: ${estadoPedido.tipoCuenta}`,
        `Referencia de pago: ${estadoPedido.referenciaPago}`,
        estadoPedido.metodoPago === 'Nequi' ? `Nequi destino: ${nequiNumero} - ${nequiNombre}` : ''
    ].filter(Boolean).join('\n');

    return `https://wa.me/${telefonoTienda}?text=${encodeURIComponent(texto)}`;
}

function finalizarPedido(){
    agregarMensaje('Gracias. Ya tengo la informacion completa. Voy a enviar el pedido a la tienda.');
    window.open(crearMensajeWhatsApp(), '_blank');
    agregarMensaje('Si WhatsApp no se abrio, revisa que el navegador permita ventanas emergentes.');
}

document.querySelectorAll('.iniciar-compra').forEach((boton) => {
    boton.addEventListener('click', () => {
        iniciarCompra({
            producto: boton.dataset.producto,
            categoria: boton.dataset.categoria,
            precio: boton.dataset.precio,
            descripcion: boton.dataset.descripcion
        });
    });
});

botonChat.addEventListener('click', () => {
    mensajes.innerHTML = '';
    abrirChat();
    agregarMensaje('Hola, soy el asistente de la tienda. Escoge una prenda y presiona Comprar para concretar un pedido.');
});

botonCerrar.addEventListener('click', cerrarChat);

formulario.addEventListener('submit', (event) => {
    event.preventDefault();

    const respuesta = input.value.trim();

    if(!respuesta){
        return;
    }

    if(!estadoPedido.producto){
        agregarMensaje(respuesta, 'cliente');
        input.value = '';
        agregarMensaje('Para concretar una venta, primero presiona el boton Comprar en una prenda.');
        return;
    }

    if(esperandoReferencia){
        agregarMensaje(respuesta, 'cliente');
        estadoPedido.referenciaPago = respuesta;
        input.value = '';
        esperandoReferencia = false;
        finalizarPedido();
        return;
    }

    if(esperandoTipoCuenta || modoPago){
        agregarMensaje(respuesta, 'cliente');
        input.value = '';
        agregarMensaje('Usa una de las opciones de pago que aparecen en el chat.');
        return;
    }

    agregarMensaje(respuesta, 'cliente');
    estadoPedido[pasosBase[pasoActual].campo] = respuesta;
    input.value = '';
    pasoActual++;

    if(pasoActual >= pasosBase.length){
        pedirMetodoPago();
        return;
    }

    agregarMensaje(pasosBase[pasoActual].pregunta);
});
