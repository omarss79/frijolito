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
            let block1 = block_boletos.filter(boleto => boleto.numero <= 1500 && boleto.estatus === 1);
            let htmlBoletos = "";
            const elementoBlockBoletos = document.getElementById("blockBoletos");
            block1.forEach(element => {
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

var URL_LIST = "https://sorteosfrijolitodelasuerte.com/api/boletos/read.php?id=";
var boletos = "";
var block_boletos = [];
var boletos_seleccionados = [];
    
function agregarBoleto(boleto) {
    let obj_boleto = {"oportunidad_1": boleto}
    obj_boleto = {"oportunidad_2": obtenerNumeroRandom()}
    obj_boleto = {"oportunidad_3": obtenerNumeroRandom()}
    obj_boleto = {"oportunidad_4": obtenerNumeroRandom()}
    // console.log(obtenerNumeroRandom());
    document.getElementById("listadoBoletos").style.display = "block";
    boletos_seleccionados.push(obj_boleto);
    boletos_seleccionados.sort((a, b) => a.oportunidad_1 < b.oportunidad_1 ? -1 : 1); 
    // console.log(boletos_seleccionados);
    ordenarBoletos();
}

function ordenarBoletos(){
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
            removerBoleto(filled_boleto);
            console.log("Eliminado: "+boletos_seleccionados);
            document.getElementById("bs_" + boleto).remove();
            document.getElementById(boleto).style.display = "block";
        });


    });
}

function limpiarBoletosAgregados(){
    let element = document.getElementById("pedidoBoletosAgregados");
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
}

function obtenerNumeroRandom()
{
    return block_boletos[Math.floor(Math.random()*block_boletos.length)]; 
}