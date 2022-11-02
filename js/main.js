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
            let block = block_boletos.filter(boleto => boleto.numero <= boletos_mostrar && boleto.estatus === 1);
            let htmlBoletos = "";
            const elementoBlockBoletos = document.getElementById("blockBoletos");
            block.forEach(element => {
                htmlBoletos += createHtmlBoleto(element.numero);
            });
            elementoBlockBoletos.innerHTML = htmlBoletos;
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
    function createHtmlBoleto(boleto) {
        let filled_boleto = boleto.toString();
        filled_boleto = filled_boleto.padStart(5, '0');
        let div =`<div class="frijolito" id="${boleto}" onclick="agregarBoleto('${filled_boleto}');">${filled_boleto}</div>`;
        return div;
    }
    
})(jQuery);

// var URL_LIST = "https://sorteosfrijolitodelasuerte.com/api/boletos/read.php?id=";
var URL_LIST = "http://localhost/omars/frijolito-api/boletos/read.php?id=";
var boletos = "";
// var block = []; 
var block_boletos = [];
var boletos_seleccionados = [];
    
function agregarBoleto(boleto) {
    let obj_boleto = {"oportunidad_1": boleto};
    apartarBoleto(boleto);
    ocultarBoletoHTML(parseInt(boleto,10));
    
    let block1 = block_boletos.filter(boleto => boleto.estatus === 1);//Boletos libres

    obj_boleto.oportunidad_2 = obtenerNumeroRandom(block1);
    apartarBoleto(obj_boleto.oportunidad_2);
    ocultarBoletoHTML(parseInt(obj_boleto.oportunidad_2,10));
    obj_boleto.oportunidad_3 = obtenerNumeroRandom(block1);
    apartarBoleto(obj_boleto.oportunidad_3);
    ocultarBoletoHTML(parseInt(obj_boleto.oportunidad_3,10));
    // obj_boleto.oportunidad_4 = obtenerNumeroRandom(block1);
    // apartarBoleto(obj_boleto.oportunidad_4);
    // ocultarBoletoHTML(parseInt(obj_boleto.oportunidad_4,10));

    document.getElementById("listadoBoletos").style.display = "block";
    boletos_seleccionados.push(obj_boleto);
    boletos_seleccionados.sort((a, b) => a.oportunidad_1 < b.oportunidad_1 ? -1 : 1); 
    listarBoletosSeleccionadosHTML();
    listarOportunidadesGeneradasHTML();
}
function listarOportunidadesGeneradasHTML(){
    boletos_seleccionados.forEach(obj_boleto => {
        let boleto1 = obj_boleto.oportunidad_1;
        let boleto2 = obj_boleto.oportunidad_2;
        let boleto3 = obj_boleto.oportunidad_3;
        // let boleto4 = obj_boleto.oportunidad_4;
        let frijolito = `<div id="lbs_${boleto1}"><b>${boleto1}</b>: [${boleto2}, ${boleto3}]</div>`;
        const elementoBoletosAgregados = document.getElementById("pedidoBoletosListado");
        elementoBoletosAgregados.insertAdjacentHTML('beforeend', frijolito);
    });
}

function obtenerNumeroRandom(block)
{
    let boleto = block[Math.floor(Math.random()*block_boletos.length)]; 
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
        document.getElementById(boleto).style.display = "none";

        let actEliminar = document.getElementById("bs_" + boleto);
        actEliminar.addEventListener('click', function(e) {
            let boleto_eliminado = boletos_seleccionados.filter(boleto => boleto.oportunidad_1 === filled_boleto);//Boletos libres
            removerBoleto(filled_boleto);
            desapartarBoleto(boleto_eliminado[0].oportunidad_2);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_2);
            desapartarBoleto(boleto_eliminado[0].oportunidad_3);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_3);
            // desapartarBoleto(boleto_eliminado[0].oportunidad_4);
            // mostrarBoletoHTML(boleto_eliminado[0].oportunidad_4);
            document.getElementById("bs_" + boleto).remove();
            document.getElementById("lbs_" + boleto).remove();
            document.getElementById(boleto).style.display = "block";
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
    for( i=0; i < boletos_seleccionados.length; i++){ 
        if ( boletos_seleccionados[i].oportunidad_1 === value) { 
            boletos_seleccionados.splice(i, 1); 
        }
    }
}

function desapartarBoleto(boleto){
    boleto_desapartado = {
        "numero": boleto,
        "estatus": 1
    };
    block_boletos.push(boleto_desapartado);
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
            if(response.status == 400){
                document.getElementById("myModal").style.display = "none";
                swal(response.data.message, "Números ocupados: " + response.data.ocupados);


                // document.getElementById("alertApartadoWarning").style.display = "block";
                // document.getElementById("alertApartadoWarning").innerHTML = "";
                // document.getElementById("alertApartadoWarning").innerHTML = response.data.message + "<br>Números ocupados: " + response.data.ocupados;
            }
        })
    }
}