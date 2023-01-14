(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });
    
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        dots: true,
        loop: true,
        center: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });

    
    $('#btnBoletos').click(function () {
        var x = document.getElementById("listadoBoletos");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    });

    document.body.onload = async function () {        
        document.getElementById("listadoBoletos").style.display = "none";
        let urlSorteo = URL_LIST + sorteo_id;
        boletos = await getBoletos(urlSorteo);
        if(boletos.status == "OK"){
            block_boletos = boletos.items;
            mostrarMasBoletos();
        } else console.log("Error al obtener los datos...");
    }
    async function getBoletos(url) {
        try {
            const data = await getData(url);
            return data;
        } catch (error) {
            console.log("Error ", error);
        }
    }

    function getData(url) {
        return new Promise((resolve, reject) => {
          axios
            .get(url)
            .then((response) => {
              resolve(response.data);
            })
            .catch((error) => {
              reject(error);
            });
        });
    }
    
})(jQuery);

var URL_LIST = "https://sorteosfrijolitodelasuerte.com/api/boletos/read.php?id=";
// var URL_LIST = "http://localhost/omars/frijolito-api/boletos/read.php?id=";
var boletos = "";
var block_boletos = [];
var boletos_seleccionados = [];
//Bucle para scroll
var bucle_inicio = 20001;
var bucle_fin = 20050;

document.addEventListener("DOMContentLoaded", function() {
    let active = false;
    const lazyLoad = function() {
      if (active === false) {
        active = true;
        setTimeout(function() {
            if(bucle_fin <= 40000) {
                mostrarMasBoletos()
            }
            active = false;
        }, 1000);
      }
    };
    document.addEventListener("scroll", lazyLoad);
});
function buscarBoletoGanador(e) {
    if(e.keyCode === 13){
        let boleto_ganador = parseInt(document.getElementById("buscador").value);
        console.log("Boleto ganador: " + boleto_ganador);

        if(boleto_ganador >= 1 && boleto_ganador <= boletos_mostrar){
            let numero_buscado = block_boletos.filter(boleto => boleto.estatus === 1 && boleto.numero === boleto_ganador);
            
            console.log(numero_buscado);
            if(numero_buscado.length == 1){
                numero_buscado = numero_buscado[0];
                console.log("Estatus: " + numero_buscado.estatus);
                agregarBoleto(numero_buscado.numero);
            }
            else{
                console.log("El número ingresado "+boleto_ganador+", no se encuentra disponible");
            }
        }
        else{
            console.log("El número ingresado no debe ser menor de 1 y mayor de "+boletos_mostrar);
        }
    }

}
function createHtmlBoleto(boleto) {
    let filled_boleto = boleto.toString();
    filled_boleto = filled_boleto.padStart(5, '0');
    let div =`<div class="frijolito" id="${boleto}" onclick="agregarBoleto('${filled_boleto}');">${filled_boleto}</div>`;
    return div;
}
function mostrarMasBoletos() {
    let block = block_boletos.filter(boleto => boleto.estatus === 1 && boleto.numero >= bucle_inicio && boleto.numero <= bucle_fin);
    let container = document.getElementById("blockBoletos");
    let htmlBoletos = container.innerHTML;

    block.forEach(element => {
        htmlBoletos += createHtmlBoleto(element.numero);
    });
    container.innerHTML = htmlBoletos;
    bucle_inicio = bucle_fin + 1;
    bucle_fin = bucle_fin + 50;
}
    
function agregarBoleto(boleto) {
    if(boleto >= 1 && boleto <= boletos_mostrar){
        let rango_op2_inicio = 0;
        let rango_op2_fin = 0;
        let rango_op3_inicio = 0;
        let rango_op3_fin = 0;

        if(boleto >= 1 && boleto <= 20000){
            rango_op2_inicio = 20001;
            rango_op2_fin = 40000;
            rango_op3_inicio = 40001;
            rango_op3_fin = 60000;
        } else if (boleto >= 20001 && boleto <= 40000){
            rango_op2_inicio = 1;
            rango_op2_fin = 20000;
            rango_op3_inicio = 40001;
            rango_op3_fin = 60000;
        } else if (boleto >= 40001 && boleto <= 60000){
            rango_op2_inicio = 1;
            rango_op2_fin = 20000;
            rango_op3_inicio = 20001;
            rango_op3_fin = 40000;
        }

        let obj_boleto = {"oportunidad_1": parseInt(boleto, 10)};
        apartarBoleto(boleto);
        ocultarBoletoHTML(parseInt(boleto,10));
        
        let block1 = block_boletos.filter(boleto => boleto.estatus === 1 && boleto.numero >= rango_op2_inicio && boleto.numero <= rango_op2_fin);//Boletos libres
        obj_boleto.oportunidad_2 = obtenerNumeroRandom(block1);
        apartarBoleto(obj_boleto.oportunidad_2);
        ocultarBoletoHTML(parseInt(obj_boleto.oportunidad_2,10));

        block1 = block_boletos.filter(boleto => boleto.estatus === 1 && boleto.numero >= rango_op3_inicio && boleto.numero <= rango_op3_fin);//Evita repetir numero de boletos
        obj_boleto.oportunidad_3 = obtenerNumeroRandom(block1);
        apartarBoleto(obj_boleto.oportunidad_3);
        ocultarBoletoHTML(parseInt(obj_boleto.oportunidad_3,10));

        document.getElementById("listadoBoletos").style.display = "block";
        boletos_seleccionados.push(obj_boleto);
        boletos_seleccionados.sort((a, b) => a.oportunidad_1 < b.oportunidad_1 ? -1 : 1); 
        listarBoletosSeleccionadosHTML();
        listarOportunidadesGeneradasHTML();
    }
}
function listarOportunidadesGeneradasHTML(){
    boletos_seleccionados.forEach(obj_boleto => {
        let boleto1 = obj_boleto.oportunidad_1;
        let boleto2 = obj_boleto.oportunidad_2;
        let boleto3 = obj_boleto.oportunidad_3;
        // let boleto4 = obj_boleto.oportunidad_4;
        let filled_boleto = boleto1.toString();
        filled_boleto = filled_boleto.padStart(5, '0');
        let frijolito = `<div id="lbs_${filled_boleto}"><b>${boleto1}</b>: [${boleto2}, ${boleto3}]</div>`;
        const elementoBoletosAgregados = document.getElementById("pedidoBoletosListado");
        elementoBoletosAgregados.insertAdjacentHTML('beforeend', frijolito);
    });
}

function obtenerNumeroRandom(block)
{   
    // console.log(block);
    let random = Math.floor(Math.random()*block.length);
    // console.log(random);
    let boleto = block[random]; 
    // console.log(boleto);
    let filled_boleto = boleto.numero.toString();
    filled_boleto = filled_boleto.padStart(5, '0');
    return filled_boleto;
}

function apartarBoleto(boleto){
    let numero = parseInt(boleto, 10);
    let boleto_apartado = block_boletos.find(el => el.numero == numero);
    boleto_apartado.estatus = 2;
}

function ocultarBoletoHTML(numero){
    if(document.getElementById( numero )){
        document.getElementById(numero).style.display = "none";
    }
}

function listarBoletosSeleccionadosHTML(){
    limpiarBoletosAgregados();
    boletos_seleccionados.forEach(obj_boleto => {
        let boleto = parseInt(obj_boleto.oportunidad_1, 10);
        let filled_boleto = boleto.toString();
        filled_boleto = filled_boleto.padStart(5, '0');
        let frijolito =`<div id="bs_${boleto}" class="frijolito">${filled_boleto}</div>`;
        const elementoBoletosAgregados = document.getElementById("pedidoBoletosAgregados");
        elementoBoletosAgregados.insertAdjacentHTML('beforeend', frijolito);
        
        if(document.getElementById( boleto )){
            document.getElementById(boleto).style.display = "none";
        }
        // document.getElementById(boleto).style.display = "none";

        let actEliminar = document.getElementById("bs_" + boleto);
        // console.log("bs_" + boleto);
        actEliminar.addEventListener('click', function(e) {
            let boleto_eliminado = boletos_seleccionados.filter(b => b.oportunidad_1 == boleto);//Boletos libres
            removerBoleto(boleto);
            desapartarBoleto(boleto_eliminado[0].oportunidad_1);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_1);
            desapartarBoleto(boleto_eliminado[0].oportunidad_2);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_2);
            desapartarBoleto(boleto_eliminado[0].oportunidad_3);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_3);
            // desapartarBoleto(boleto_eliminado[0].oportunidad_4);
            // mostrarBoletoHTML(boleto_eliminado[0].oportunidad_4);

            console.log("boleto_eliminado" + JSON.stringify(boleto_eliminado));
            console.log("lbs_" + boleto);
            document.getElementById("bs_" + boleto).remove();
            if(document.getElementById("lbs_" + filled_boleto)){
                document.getElementById("lbs_" + filled_boleto).remove();
            }
            if(document.getElementById(boleto)){
                document.getElementById(boleto).style.display = "block";
            }
            // document.getElementById(boleto).style.display = "block";
            listarBoletosSeleccionadosHTML();
            listarOportunidadesGeneradasHTML();
        });
    });
}
function limpiarBoletosAgregados(){
    let element = document.getElementById("pedidoBoletosAgregados");
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
    element = document.getElementById("pedidoBoletosListado");
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
}

function removerBoleto(value) {
    console.log("value" + value);
    console.log("boletos_seleccionados" + JSON.stringify(boletos_seleccionados));
    for( i=0; i < boletos_seleccionados.length; i++){ 
        if ( boletos_seleccionados[i].oportunidad_1 === value) { 
            boletos_seleccionados.splice(i, 1); 
        }
    }
    console.log("boletos_seleccionados despues" + JSON.stringify(boletos_seleccionados));
}

function desapartarBoleto(boleto){
    // Eliminar boleto por estatus == 2
    console.log("Boleto: "+boleto);
    for( i=0; i < block_boletos.length; i++){ 
        if ( block_boletos[i].numero === boleto) { 
            block_boletos.splice(i, 1); 
        }
    }
    // Agregar boleto para asigar estatus = 1 (desapartar)
    boleto_desapartado = {
        "numero": boleto,
        "estatus": 1
    };
    block_boletos.push(boleto_desapartado);
    // console.log("Boleto desapartado: "+boleto);
    // console.log("Boleto desapartado agregado: "+JSON.stringify(block_boletos));

    // const indiceElemento = block_boletos.findIndex(b => b.numero == boleto )
    // let new_block_boletos = [...block_boletos]
    // console.log("Boleto index: "+JSON.stringify(new_block_boletos[indiceElemento]));
    // new_block_boletos[indiceElemento] = {...new_block_boletos[indiceElemento], estatus: 1}
    // console.log("Boleto index 2: "+JSON.stringify(new_block_boletos[indiceElemento]));
    // block_boletos = new_block_boletos
    console.log("Boleto desapartado despues: "+JSON.stringify(block_boletos));
}

function mostrarBoletoHTML(boleto){
    let numero = parseInt(boleto, 10);
    if(document.getElementById(numero)){
        document.getElementById(numero).style.display = "block";
    }
}

// MODAL SHOW DETAILS
async function apartarBoletosModal(){
    if(boletos_seleccionados.length == 0){
        // alert("Debe seleccionar al menos 1 boleto para participar.");
        let msj = `<div><b>Debe seleccionar al menos 1 boleto para participar.</b></div>`;
        const elementoBoletosAgregados = document.getElementById("pedidoBoletosAgregados");
        elementoBoletosAgregados.innerHTML = msj;
    }
    else{
        // Get the modal
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    }
}

let closeModalSpan = document.getElementById("closeModal");
closeModalSpan.addEventListener('click', function(e) {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

$('#celular').on('input', function () { validarNumeros(this);});
function validarNumeros(field) { 
    if(event.shiftKey) event.preventDefault();
    let old_input = field.value;
    field.value = old_input.replace(/[^0-9]/g,'');
    if(field.value.length >= 10) event.preventDefault();
}

function enviarBoletosApartados(){
    let celular = document.getElementById("celular").value;
    let nombre = document.getElementById("nombre").value;
    let apellidos = document.getElementById("apellidos").value;
    let estado_id = document.getElementById("estado_id").value;
    if(celular == ""){
        document.getElementById("celular").focus();
    }
    else if(nombre == ""){
        document.getElementById("nombre").focus();
    }
    else if(apellidos == ""){
        document.getElementById("apellidos").focus();
    }
    else if(estado_id == ""){
        document.getElementById("estado_id").focus();
    }
    else{
        let data ={
            celular: celular,
            nombre: nombre,
            apellidos: apellidos,
            estado_id: estado_id,
            boletos: boletos_seleccionados
        }
        axios.post('ajax/ajax_apartar_boletos.php', data)
        .then(res => {
            if(res.status == 201){
                document.getElementById("myModal").style.display = "none";
                let mensaje = " Hola, Aparte boletos de la rifa!! \n "+premio_1+"!! \n ————————————\n";
                if(boletos_seleccionados.length === 1) mensaje += "*"+boletos_seleccionados.length+" BOLETO:* \n";
                else mensaje += "*"+boletos_seleccionados.length+" BOLETOS:* \n";
                boletos_seleccionados.forEach(element => {
                    mensaje += "*"+element.oportunidad_1+"* ("+element.oportunidad_2+", "+element.oportunidad_3+")\n";
                });
                mensaje += "\n";
                mensaje += "*Nombre:* "+nombre+" "+apellidos+"\n\n";
                mensaje += "1 BOLETO POR $40\n3 BOLETOS POR $120\n5 BOLETOS POR $200\n10 BOLETOS POR $400\n";
                mensaje += " ———————————— \n *CUENTAS DE PAGO AQUÍ:* https://sorteosfrijolitodelasuerte.com\n El siguiente paso es enviar foto del comprobante de pago por aquí";
                window.open('https://api.whatsapp.com/send?phone=5216674472711&text='+mensaje.replace(/\n/g,'%0A'), '_blank');
                window.location="sorteo.php";
            }
        })
        .catch(err => {
            let response = err.response;
            console.log(response.data);
            if(response.status == 400){
                document.getElementById("myModal").style.display = "none";
                let ocupados = "";
                if(response.data.ocupados != undefined) ocupados = "Números ocupados: " + response.data.ocupados;
                // ocupados = "Números ocupados: ";
                swal(response.data.message, ocupados);
            }
            else if(response.status == 503){
                document.getElementById("myModal").style.display = "none";
                swal(response.data.message);
            }
            else{
                swal("Error, al apartar los boletos, consulte con su administrador...");
            }
        })
    }
}