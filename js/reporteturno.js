$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: '../model/MostrarTurnoReporte.php',
    })
    .done(function(categ){
        $('#turno').html(categ);
    })
    .fail(function(){
        alert('Hubo un error al cargar los turnos');
    });

    $('#turno').on('change', function(){

        $('#year').html('<option value="">Cargando...</option>'); // Show loading message

        var id = $(this).val(); // Use $(this).val() to get selected value
        $.ajax({
            type: 'POST',
            url: '../model/MostrarYear.php',
            data: {'idturno': id}
        })
        .done(function(categ){
            $('#year').html(categ);
        })
        .fail(function(){
            alert('Hubo un error al cargar los servicios');
        });
    });
});