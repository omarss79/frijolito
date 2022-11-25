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
    
    let btnVerificar = document.getElementById("boleto");
    btnVerificar.addEventListener('click', function(e) {
        document.getElementById("tabla").style.display = "none";
        document.getElementById("respuesta").style.display = "none";
        document.getElementById("boleto-error").style.display = "none";
        document.getElementById("verificar_boleto").disabled = false;
    });    
})(jQuery);



function verificarNumero() {
    if(document.getElementById("boleto").value === ""){
        document.getElementById("boleto").focus(); 
    }
    else{
        if (    (document.getElementById("boleto").value.length >= 1 && document.getElementById("boleto").value.length <= 5) 
                || document.getElementById("boleto").value.length === 10
            ) {

            document.getElementById("boleto-error").style.display = "none";
            let boleto = document.getElementById("boleto").value;
            let data ={
                boleto: boleto
            }
            axios.post('ajax/ajax_verificar_boleto.php', data)
            .then(res => {
                if(res.status == 201){
                    let data = res.data.items;
                    let table = '<table class="table text-center">';
                    table += '<thead class="table-light">';
                    table += '<th scope="col">#</th>';
                    table += '<th scope="col">Boleto</th>';
                    table += '<th scope="col">Estatus</th>';
                    table += '<th scope="col">Nombre</th>';
                    table += '</thead>';
                    table += '<tbody>';
                    let b = 1;
                    data.forEach(element => {
                        table += '<tr>';
                        table += '<td>'+b+'</td>';
                        table += '<td>'+element.numero+'</td>';
                        table += '<td>'+element.estatus+'</td>';
                        table += '<td>'+element.nombre+' '+element.apellidos+'</td>';
                        table += '</tr>';
                        b++;
                    });
                    table += '</tbody>';
                    table += '</table>';
                    document.getElementById("tabla").innerHTML = table;
                    document.getElementById("tabla").style.display = "block";
                    document.getElementById("verificar_boleto").disabled = true;
                } 
                else if(res.status == 200){
                    let data = res.data;
                    document.getElementById("respuesta").innerHTML = data.html + '<div id="verificar_cerrar" onclick="cerrarAlert();" style="float: right;"><strong>x</strong></div>';
                    document.getElementById("respuesta").style.display = "block";
                    document.getElementById("verificar_boleto").disabled = true;
                }
            })
            .catch(err => {
                let response = err.response;
            })
        }
        else{
            document.getElementById("boleto").focus(); 
            document.getElementById("boleto-error").innerHTML = "Debe ingresar un número de boleto (1 a 5 caracteres) o celular (10 caracteres)";
            document.getElementById("boleto-error").style.display = "block";
        }
    }
}

function cerrarAlert() {
    document.getElementById("tabla").style.display = "none";
    document.getElementById("respuesta").style.display = "none";
    document.getElementById("boleto-error").style.display = "none";
    document.getElementById("verificar_boleto").disabled = false;
    document.getElementById("boleto").focus();
}


