$(document).ready(function(){
    $.ajax({
        type: 'POST',
        url: '../model/MostrarTurno.php',
    })
    .done(function(categ){
        $('#turno').html(categ);
    })
    .fail(function(){
        alert('Hubo un error al cargar los turnos');
    });

    $('#turno').on('change', function(){

        $('#mes').html('<option value="">Cargando...</option>'); // Show loading message

        var id = $(this).val(); // Use $(this).val() to get selected value
        $.ajax({
            type: 'POST',
            url: '../model/MostrarMes.php',
            data: {'idturno': id}
        })
        .done(function(categ){
            $('#mes').html(categ);
        })
        .fail(function(){
            alert('Hubo un error al cargar los servicios');
        });
    });
});