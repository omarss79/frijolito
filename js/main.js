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
            let block = block_boletos.filter(boleto => boleto.numero <= 15000 && boleto.estatus === 1);
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
    console.log(block_boletos);
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
    obj_boleto.oportunidad_4 = obtenerNumeroRandom(block1);
    apartarBoleto(obj_boleto.oportunidad_4);
    ocultarBoletoHTML(parseInt(obj_boleto.oportunidad_4,10));

    document.getElementById("listadoBoletos").style.display = "block";
    boletos_seleccionados.push(obj_boleto);
    boletos_seleccionados.sort((a, b) => a.oportunidad_1 < b.oportunidad_1 ? -1 : 1); 
    console.log(boletos_seleccionados);
    listarBoletosSeleccionadosHTML();
    listarOportunidadesGeneradasHTML();
}
function listarOportunidadesGeneradasHTML(){
    boletos_seleccionados.forEach(obj_boleto => {
        let boleto1 = obj_boleto.oportunidad_1;
        let boleto2 = obj_boleto.oportunidad_2;
        let boleto3 = obj_boleto.oportunidad_3;
        let boleto4 = obj_boleto.oportunidad_4;
        let frijolito = `<div id="lbs_${boleto1}"><b>${boleto1}</b>: [${boleto2}, ${boleto3}, ${boleto4}]</div>`;
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
            console.log("Eliminado: "+boletos_seleccionados);
            let boleto_eliminado = boletos_seleccionados.filter(boleto => boleto.oportunidad_1 === filled_boleto);//Boletos libres
            removerBoleto(filled_boleto);
            desapartarBoleto(boleto_eliminado[0].oportunidad_2);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_2);
            desapartarBoleto(boleto_eliminado[0].oportunidad_3);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_3);
            desapartarBoleto(boleto_eliminado[0].oportunidad_4);
            mostrarBoletoHTML(boleto_eliminado[0].oportunidad_4);
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
        console.log(boletos_seleccionados[i].oportunidad_1);
        if ( boletos_seleccionados[i].oportunidad_1 === value) { 
            boletos_seleccionados.splice(i, 1); 
        }
    }
    console.log(boletos_seleccionados);
}

function desapartarBoleto(boleto){
    boleto_desapartado = {
        "numero": boleto,
        "estatus": 1
    };
    block_boletos.push(boleto_desapartado);
    console.log(block_boletos);
}

function mostrarBoletoHTML(boleto){
    let numero = parseInt(boleto, 10);
    if(document.getElementById(numero)){
        document.getElementById(numero).style.display = "block";
    }
    console.log(numero);
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
        // document.getElementById("modalContent").style.height = "80%";
        // document.getElementById("modalContent").style.width = "80%";
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
    let celular = document.getElementById("apellidos").value;
    let nombre = document.getElementById("celular").value;
    let apellidos = document.getElementById("nombre").value;
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
        .then(res => console.log(res))
        .catch(err => console.log(err))
    }
}