
$(function(){
    validarNumeros();
    validarLetras();
    validarnum();
    soloNumeros();
});

function validarNumeros(){
    $(".solo-numeros").keydown(function(event) {
    
        // Desactivamos cualquier combinación con shift
        if(event.shiftKey)
            event.preventDefault();
         
        /*  
            No permite ingresar pulsaciones a menos que sean los siguientes
            KeyCode Permitidos
            keycode 8 Retroceso
            keycode 37 Flecha Derecha
            keycode 39  Flecha Izquierda
            keycode 46 Suprimir
        */
        //No permite mas de 11 caracteres Numéricos
        if (event.keyCode != 46 && event.keyCode != 8 && event.keyCode != 37 && event.keyCode != 39) 
            if($(this).val().length >= 11)
                event.preventDefault();
    
        // Solo Numeros del 0 a 9 
        if (event.keyCode < 48 || event.keyCode > 57)
            //Solo Teclado Numerico 0 a 9
            if (event.keyCode < 96 || event.keyCode > 105)
                /*  
                    No permite ingresar pulsaciones a menos que sean los siguietes
                    KeyCode Permitidos
                    keycode 8 Retroceso
                    keycode 37 Flecha Derecha
                    keycode 39  Flecha Izquierda
                    keycode 46 Suprimir
                */
                if(event.keyCode != 46 && event.keyCode != 8 && event.keyCode != 37 && event.keyCode != 39)
                    event.preventDefault();

    });
}

function validarLetras(){
    $('.solo-letras').keypress(function (e) {
        var tecla = document.all ? tecla = e.keyCode : tecla = e.which;
        return !((tecla > 47 && tecla < 58) || tecla == 46);
    });
}

function validarnum(){
    $('.decimal').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
             val = val.replace(/[^0-9\.]/g,'');
             if(val.split('.').length>2) 
                 val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });   
}

function soloNumeros(){
    $('.soloNumeros').keydown(function(e) {
      var key = e.charCode || e.keyCode || 0;
      // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
      return (
        key == 8 ||
        key == 9 ||
        key == 46 ||
        (key >= 37 && key <= 40) ||
        (key >= 48 && key <= 57) ||
        (key >= 96 && key <= 105));
    });
  }