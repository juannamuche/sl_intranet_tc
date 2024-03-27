var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000
});

function init() {
    select_medida('TallaPechoVaron');
    select_medida('TallaCinturaVaron');
    select_medida('TallaHombroVaron');
    select_medida('TallaLargoCuerpoVaron');
    select_medida('TallaLargoMangaVaron');
    select_medida('TallaPantalonCinturaVaron');
    select_medida('TallaPantalonCaderaVaron');
    select_medida('TallaPantalonMusloVaron');
    select_medida('TallaPechoDama');
    select_medida('TallaCinturaDama');
    select_medida('TallaLargoCuerpoDama');
    select_medida('TallaLargoMangaDama');
    select_medida('TallaPantalonCinturaMujer');
    select_medida('TallaPantalonCaderaMujer');
    select_medida('TallaCalzado');
    select_medida('TallaCasaca');
    select_medida('TallaChaleco');
    if ($('#sexo').val() == "MASCULINO") {
        $('#divblusa').hide();
        $('#divcamisa').show();
    } else {
        $('#divblusa').show();
        $('#divcamisa').hide();
    }
    $('#divpantalonhombre').hide();
    $('#divpantalonmujer').hide();
    $('#divadicionales').hide();
    $('#divdatos').hide();
    $('#btnatras').hide();
    $('#btnguardar').hide();

    mostrar_uniformes_persona();
}

function select_medida(tipoMedida) {
    $.ajax({
        url: "../ajax/uniformes.php?op=select_medida",
        type: "POST",
        data: { "tipomedida": tipoMedida },
        dataType: "json",
        success: function (data) {
            if (tipoMedida == 'TallaPechoVaron') {
                $('#pechovaron').html(data.html);
            } else if (tipoMedida == 'TallaCinturaVaron') {
                $('#cinturavaron').html(data.html);
            } else if (tipoMedida == 'TallaHombroVaron') {
                $('#hombrovaron').html(data.html);
            } else if (tipoMedida == 'TallaLargoCuerpoVaron') {
                $('#lcuerpovaron').html(data.html);
            } else if (tipoMedida == 'TallaLargoMangaVaron') {
                $('#lmangavaron').html(data.html);
            } else if (tipoMedida == 'TallaPantalonCinturaVaron') {
                $('#pcinturavaron').html(data.html);
            } else if (tipoMedida == 'TallaPantalonCaderaVaron') {
                $('#pcaderavaron').html(data.html);
            } else if (tipoMedida == 'TallaPantalonMusloVaron') {
                $('#pmuslovaron').html(data.html);
            } else if (tipoMedida == 'TallaPechoDama') {
                $('#pechomujer').html(data.html);
            } else if (tipoMedida == 'TallaCinturaDama') {
                $('#cinturamujer').html(data.html);
            } else if (tipoMedida == 'TallaLargoCuerpoDama') {
                $('#lcuerpomujer').html(data.html);
            } else if (tipoMedida == 'TallaLargoMangaDama') {
                $('#lmangamujer').html(data.html);
            } else if (tipoMedida == 'TallaPantalonCinturaMujer') {
                $('#pcinturamujer').html(data.html);
            } else if (tipoMedida == 'TallaPantalonCaderaMujer') {
                $('#pcaderamujer').html(data.html);
            } else if (tipoMedida == 'TallaCalzado') {
                $('#calzado').html(data.html);
            } else if (tipoMedida == 'TallaCasaca') {
                $('#casaca').html(data.html);
            } else if (tipoMedida == 'TallaChaleco') {
                $('#chaleco').html(data.html);
            }

        }
    });
}

function mostrar_uniformes_persona() {
    $.ajax({
        url: "../ajax/uniformes.php?op=mostrar_uniformes_persona",
        type: "POST",
        data: {},
        dataType: "json",
        success: function (data) {
            if (data.status) {             
                $('#pechovaron').val(data.datos.talla_camisa_pecho);
                $('#cinturavaron').val(data.datos.talla_camisa_cintura);
                $('#hombrovaron').val(data.datos.talla_camisa_hombro);
                $('#lcuerpovaron').val(data.datos.talla_camisa_largo);
                $('#lmangavaron').val(data.datos.talla_camisa_manga);

                $('#pcinturavaron').val(data.datos.talla_pantalon_cintura);
                $('#pcaderavaron').val(data.datos.talla_pantalon_cadera);
                $('#pmuslovaron').val(data.datos.talla_pantalon_muslo);
                $('#lpiernasvaron').val(data.datos.talla_pantalon_largo);

                $('#pechomujer').val(data.datos.talla_camisa_pecho);
                $('#cinturamujer').val(data.datos.talla_camisa_cintura);               
                $('#lcuerpomujer').val(data.datos.talla_camisa_largo);
                $('#lmangamujer').val(data.datos.talla_camisa_manga);

                $('#pcinturamujer').val(data.datos.talla_pantalon_cintura);
                $('#pcaderamujer').val(data.datos.talla_pantalon_cadera);           
                $('#lpiernasmujer').val(data.datos.talla_pantalon_largo);

                $('#calzado').val(data.datos.talla_zapato);
                $('#casaca').val(data.datos.talla_casaca);
                $('#chaleco').val(data.datos.talla_chaleco);

                $('#ubicacion').val(data.datos.lugar_recojo);
                $('#datos').val(data.datos.tipo_envio);
                $('#nombres').val(data.datos.nombre_contacto);
                $('#celular').val(data.datos.celular_contacto);
                $('#DNI').val(data.datos.dni_contacto);           
            }
        }
    });
}

function mostrar(tipo) {

    if (tipo == 2) {
        if ($('#sexo').val() == "MASCULINO") {
            if ($('#divcamisa').is(":visible")) {
                $('#divcamisa').hide();
                $('#divpantalonhombre').show();
                $('#btnatras').show();
            } else if ($('#divpantalonhombre').is(":visible")) {
                $('#divpantalonhombre').hide();
                $('#divadicionales').show();
                $('#divdatos').show();
                $('#div-datos').hide();
                $('.otros-datos').hide();
                $('#btnatras').show();
                $('#btnsiguiente').hide();
                $('#btnguardar').show();
            }
        } else {
            if ($('#divblusa').is(":visible")) {
                $('#divblusa').hide();
                $('#divpantalonmujer').show();
                $('#btnatras').show();
            } else if ($('#divpantalonmujer').is(":visible")) {
                $('#divpantalonmujer').hide();
                $('#divadicionales').show();
                $('#divdatos').show();
                $('#div-datos').hide();
                $('.otros-datos').hide();
                $('#btnatras').show();
                $('#btnsiguiente').hide();
                $('#btnguardar').show();
            }
        }
    } else {
        if ($('#sexo').val() == "MASCULINO") {
            if ($('#divpantalonhombre').is(":visible")) {
                $('#divpantalonhombre').hide();
                $('#divcamisa').show();
                $('#btnatras').hide();
            } else if ($('#divadicionales').is(":visible")) {
                $('#divadicionales').hide();
                $('#divpantalonhombre').show();
                $('#divdatos').hide();
                $('#btnatras').show();
                $('#btnsiguiente').show();
                $('#btnguardar').hide();
            }
        } else {
            if ($('#divpantalonmujer').is(":visible")) {
                $('#divpantalonmujer').hide();
                $('#divblusa').show();
                $('#btnatras').hide();
            } else if ($('#divadicionales').is(":visible")) {
                $('#divadicionales').hide();
                $('#divpantalonmujer').show();
                $('#divdatos').hide();
                $('#btnatras').show();
                $('#btnsiguiente').show();
                $('#btnguardar').hide();
            }
        }
    }
}

function ubicacion_envio() {
    if ($('#ubicacion').val() == 2) {
        $('#div-datos').show();
    } else {
        $('#div-datos').hide();
        $('#datos').val(0);
    }
    envio();
}

function envio() {
    if ($('#datos').val() == 2) {
        $('.otros-datos').show();
    } else {
        $('.otros-datos').hide();
    }
}

function guardar() {
    if ($('#sexo').val() == "MASCULINO") {
        if (document.getElementById('pechovaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de pecho'
            });
            return false;
        }
        if (document.getElementById('cinturavaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de cintura'
            });
            return false;
        }
        if (document.getElementById('hombrovaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de hombro'
            });
            return false;
        }
        if (document.getElementById('lcuerpovaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo de cuerpo'
            });
            return false;
        }
        if (document.getElementById('lmangavaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo de manga'
            });
            return false;
        }
        if (document.getElementById('pcinturavaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de cintura de pantalon'
            });
            return false;
        }
        if (document.getElementById('pcaderavaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de cadera'
            });
            return false;
        }
        if (document.getElementById('pmuslovaron').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo de muslo'
            });
            return false;
        }
        if (document.getElementById('lpiernasvaron').value == "") {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo de piernas'
            });
            return false;
        }
    } else {
        if (document.getElementById('pechomujer').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de pecho'
            });
            return false;
        }
        if (document.getElementById('cinturamujer').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de cintura'
            });
            return false;
        }
        if (document.getElementById('lcuerpomujer').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo del cuerpo'
            });
            return false;
        }
        if (document.getElementById('lmangamujer').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo de manga'
            });
            return false;
        }
        if (document.getElementById('pcinturamujer').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de cintura de pantalon'
            });
            return false;
        }
        if (document.getElementById('pcaderamujer').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de cadera'
            });
            return false;
        }
        if (document.getElementById('lpiernasmujer').value == '') {
            Toast.fire({
                icon: 'info',
                title: 'Debe ingresar medida de largo de piernas'
            });
            return false;
        }
    }
    if (document.getElementById('calzado').value == 0) {
        Toast.fire({
            icon: 'info',
            title: 'Debe ingresar talla de calzado'
        });
        return false;
    }
    if (document.getElementById('casaca').value == 0) {
        Toast.fire({
            icon: 'info',
            title: 'Debe ingresar talla de casaca'
        });
        return false;
    }
    if (document.getElementById('chaleco').value == 0) {
        Toast.fire({
            icon: 'info',
            title: 'Debe ingresar talla de chaleco'
        });
        return false;
    }
    if (document.getElementById('ubicacion').value == 0) {
        Toast.fire({
            icon: 'info',
            title: 'Debe elegir ubicacion'
        });
        return false;
    }
    if (document.getElementById('ubicacion').value == 2) {
        if (document.getElementById('datos').value == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Debe elegir metodo de envio'
            });
            return false;
        }
        if (document.getElementById('datos').value == 2) {
            if (document.getElementById('nombres').value == '') {
                Toast.fire({
                    icon: 'info',
                    title: 'Debe ingresar nombres y apellidos'
                });
                return false;
            }
            if (document.getElementById('celular').value == '') {
                Toast.fire({
                    icon: 'info',
                    title: 'Debe ingresar número de celular'
                });
                return false;
            }
            if (document.getElementById('DNI').value == '') {
                Toast.fire({
                    icon: 'info',
                    title: 'Debe ingresar número de DNI'
                });
                return false;
            }
        }
    }

    var formData = new FormData($('#formUniforme')[0]);

    $.ajax({
        url: "../ajax/uniformes.php?op=guardar_uniforme",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (data) {
            console.log(data)
            Toast.fire({
                icon: data.ico,
                title: data.msg
            });
        }
    });
}

init();


