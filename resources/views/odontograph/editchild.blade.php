@extends('layouts.app')


@section('content')


<link type="text/css" href="{{ URL::asset('css/custom-theme/jquery-ui-1.8.13.custom.css') }}" rel="stylesheet" />

<script type="text/javascript" src="{{ URL::asset('js/jquery-1.7.2.min.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/jquery-ui-1.8.13.custom.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>



<style>


body {
    text-align: center;
}

#canvasesdiv {
    margin-left: 400px;
}

h1 {
    margin-bottom: 20px;
    color:var(--background);
}

#radio {
    display: flex;
    justify-content: space-around;
    align-items: center;
    background-color:var(--background);
    /* Color de fondo del contenedor */
    border-radius: 5px;
    /* Bordes redondeados */
    padding: 10px;
    /* Espaciado interno */
    color: #fff;
    padding-top: 15px;
}

/* Estilo común para los radios */
#radio input[type="radio"],
#radio_seccion input[type="radio"] {
    display: none;
    /* Oculta los radios por defecto */

}

/* Estilo del label como botón */
#radio label,
#radio_seccion label {
    display: inline-block;
    padding: 10px 15px;
    cursor: pointer;
    border: 1px solid #fff;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;

}

.btn-pink {
    background-color:var(--background);
    color: var(--txt);
}


#radio_seccion label {
    border-color: #000;
}

/* Estilo del label cuando el radio está seleccionado */
#radio input[type="radio"]:checked+label,
#radio_seccion input[type="radio"]:checked+label {
    background-color: #fff;
    /* Cambia el color de fondo al seleccionar */
    color:var(--background);
    border-color:var(--background);
    /* Cambia el color del texto al seleccionar */
}
</style>




<h1>Odontodiagrama para Pediatria</h1>


<div id="radio">
    <!-- Color rojo -->
    <input type="radio" id="radio1" name="accion" value="fractura" checked="checked" /><label for="radio1">Cariado <i
            class="fas fa-teeth"></i></label>
    <!-- Color Azul -->
    <input type="radio" id="radio2" name="accion" value="restauracion" /><label for="radio2">Restaurado <i
            class="fas fa-teeth"></i></label>
    <!-- Tres lineas Verticales -->
    <input type="radio" id="radio4" name="accion" value="extraccion" /><label for="radio4"> <i
            class="fas fa-teeth-open"></i>
        Extraccion</label>

    <!-- linea horizontal roja -->
    <input type="radio" id="radio5" name="accion" value="puente" /><label for="radio5"><i class="fas fa-teeth"></i>
        Corona</label>

    <input type="radio" id="radio3" name="accion" value="borrar" /><label for="radio3">Borrar <i
            class="fas fa-trash"></i></label>


    <!-- Color Amarillo -->
    <input type="radio" id="radio6" name="accion" value="Endodoncia" /><label for="radio6"><i class="fas fa-teeth"></i>
        Endodoncia</label>

    <!-- Equis negra -->
    <input type="radio" id="radio8" name="accion" value="ausencia" /><label for="radio8"><i class="fas fa-teeth"></i>
        Ausencia</label>
    <!-- color Verde -->
    <input type="radio" id="radio7" name="accion" value="Implante" /><label for="radio7"><i class="fas fa-teeth"></i>
        Implante</label>
</div>
<br>
<div id="canvasesdiv" style="position:relative; width:510px; height:200px">
    <canvas id="myCanvas" width="510" height="200" style="z-index: 1; position:absolute; left:0px; top:0px;"></canvas>
    <canvas id="myCanvas2" width="510" height="200" style="z-index: 2; position:absolute; left:0px; top:0px;"></canvas>
    <canvas id="myCanvas3" width="510" height="200" style="z-index: 3; position:absolute; left:0px; top:0px;"></canvas>
    <canvas id="myCanvas4" width="510" height="200" style="z-index: 4; position:absolute; left:0px; top:0px;"></canvas>
</div>

<br />
<div id="radio_seccion" style='display:none'>
    <input type="radio" id="radio_1" name="seccion" value="seccion" checked="checked" /><label for="radio_1"><i
            class="fas fa-teeth"></i> Seccion</label>
    <input type="radio" id="radio_2" name="seccion" value="diente" /><label for="radio_2"><i class='fas fa-teeth'></i>
        Diente</label>
</div>

<button class="btn btn-pink" type="button" id="reiniciarPagina">
    <i class="fa fa-teeth fa-spin "></i> Reiniciar Odontograma
</button>
<button class="btn btn-pink"  id="saveButton"> <i class="fa fa-save"></i> Guardar</button>



<script>
    
$(function() {
    
    $("#radio").buttonset();
    $("#radio_seccion").buttonset();
    $('#radio').change(function() {
        accion = $("input[name='accion']:checked").val();
        if (accion == 'borrar') {
            $("#radio_seccion").show('blind', 500);
        } else {
            $("#radio_seccion").hide();
        }
    });
});
document.getElementById('reiniciarPagina').addEventListener('click', function() {
    // Recarga la página
   
    location.reload();
});
</script>
<script type="text/javascript" src="{{ URL::asset('js/html2canvas.js') }}"></script>


<script>
// Funcion para dibujar las lineas de cada diente
function dibuja_contorno(context, inicio_x, inicio_y, med, separacion_x, separacion_y) {
    var ctx = context;
    // Definiendo puntos de dibujo
    cua = med / 4;
    ter = cua * 3;
    /* 1ra zona */
    if (ctx) {
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(inicio_x, inicio_y);
        ctx.lineTo(med + inicio_x, inicio_y);
        ctx.lineTo(ter + inicio_x, cua + inicio_y);
        ctx.lineTo(cua + inicio_x, cua + inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
    /* 2da zona */
    if (ctx) {
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(ter + inicio_x, cua + inicio_y);
        ctx.lineTo(med + inicio_x, inicio_y);
        ctx.lineTo(med + inicio_x, med + inicio_y);
        ctx.lineTo(ter + inicio_x, ter + inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
    /* 3ra zona */
    if (ctx) {
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(cua + inicio_x, ter + inicio_y);
        ctx.lineTo(ter + inicio_x, ter + inicio_y);
        ctx.lineTo(med + inicio_x, med + inicio_y);
        ctx.lineTo(inicio_x, med + inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
    /* 4ta zona */
    if (ctx) {
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(inicio_x, inicio_y);
        ctx.lineTo(cua + inicio_x, cua + inicio_y);
        ctx.lineTo(cua + inicio_x, ter + inicio_y);
        ctx.lineTo(inicio_x, med + inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
}
// Funcion para pintar una region del diente
function dibuja_seccion(contexto, num_diente, seccion, color_pas) {
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    cua = med / 4;
    ter = cua * 3;
    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente < 16) {
        inicio_y = 20;
    } else {
        num_diente = num_diente - 16;
        inicio_y = med + 100;
        //if(num_diente==1){num_diente=0;}
    }
    //swal.fire(num_diente);
    inicio_x = (num_diente * med) + (separacion_x * num_diente) + separacion_x;
    /* 1ra zona */
    if (seccion == 1) {
        if (ctx) {

            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x, inicio_y);
            ctx.lineTo(med + inicio_x, inicio_y);
            ctx.lineTo(ter + inicio_x, cua + inicio_y);
            ctx.lineTo(cua + inicio_x, cua + inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 2da zona */
    if (seccion == 2) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(ter + inicio_x, cua + inicio_y);
            ctx.lineTo(med + inicio_x, inicio_y);
            ctx.lineTo(med + inicio_x, med + inicio_y);
            ctx.lineTo(ter + inicio_x, ter + inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 3ra zona */
    if (seccion == 3) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua + inicio_x, ter + inicio_y);
            ctx.lineTo(ter + inicio_x, ter + inicio_y);
            ctx.lineTo(med + inicio_x, med + inicio_y);
            ctx.lineTo(inicio_x, med + inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 4ta zona */
    if (seccion == 4) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x, inicio_y);
            ctx.lineTo(cua + inicio_x, cua + inicio_y);
            ctx.lineTo(cua + inicio_x, ter + inicio_y);
            ctx.lineTo(inicio_x, med + inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 5ta zona(medio) */
    if (seccion == 5) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua + inicio_x, cua + inicio_y);
            ctx.lineTo(ter + inicio_x, cua + inicio_y);
            ctx.lineTo(ter + inicio_x, ter + inicio_y);
            ctx.lineTo(cua + inicio_x, ter + inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
}
//
// Funcion para sombrear
function marcar_seccion(contexto, num_diente, seccion, color_pas) {
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    cua = med / 4;
    ter = cua * 3;
    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente < 16) {
        inicio_y = 20;
    } else {
        num_diente = num_diente - 16;
        inicio_y = med + 100;
        //if(num_diente==1){num_diente=0;}
    }
    //swal.fire(num_diente);
    inicio_x = (num_diente * med) + (separacion_x * num_diente) + separacion_x;
    /* 1ra zona */
    if (seccion == 1) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x, inicio_y);
            ctx.lineTo(med + inicio_x, inicio_y);
            ctx.lineTo(ter + inicio_x, cua + inicio_y);
            ctx.lineTo(cua + inicio_x, cua + inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 2da zona */
    if (seccion == 2) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(ter + inicio_x, cua + inicio_y);
            ctx.lineTo(med + inicio_x, inicio_y);
            ctx.lineTo(med + inicio_x, med + inicio_y);
            ctx.lineTo(ter + inicio_x, ter + inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 3ra zona */
    if (seccion == 3) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua + inicio_x, ter + inicio_y);
            ctx.lineTo(ter + inicio_x, ter + inicio_y);
            ctx.lineTo(med + inicio_x, med + inicio_y);
            ctx.lineTo(inicio_x, med + inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 4ta zona */
    if (seccion == 4) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x, inicio_y);
            ctx.lineTo(cua + inicio_x, cua + inicio_y);
            ctx.lineTo(cua + inicio_x, ter + inicio_y);
            ctx.lineTo(inicio_x, med + inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 5ta zona(medio) */
    if (seccion == 5) {
        if (ctx) {
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua + inicio_x, cua + inicio_y);
            ctx.lineTo(ter + inicio_x, cua + inicio_y);
            ctx.lineTo(ter + inicio_x, ter + inicio_y);
            ctx.lineTo(cua + inicio_x, ter + inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
}
// Funcion para sombrear diente completo
function marcar_diente(contexto, num_diente, color_pas) {
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente < 16) {
        inicio_y = 20;
    } else {
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }
    //swal.fire(num_diente);
    inicio_x = (num_diente * med) + (separacion_x * num_diente) + separacion_x;

    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.moveTo(inicio_x, inicio_y);
    ctx.lineTo(inicio_x + 40, inicio_y);
    ctx.lineTo(inicio_x + 40, inicio_y + 40);
    ctx.lineTo(inicio_x, inicio_y + 40);
    ctx.closePath();
    ctx.strokeStyle = color_line;
    ctx.stroke();
}
// Funcion para sombrear diente completo
function marcar_extraccion(contexto, num_diente, color_pas) {
    var ctx = contexto;
    // Definiendo puntos de dibujo

    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente < 16) {
        inicio_y = 20;
    } else {
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }
    //swal.fire(num_diente);
    inicio_x = (num_diente * med) + (separacion_x * num_diente) + separacion_x;

    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.lineWidth = 3;
    console.log('pipipi')
    // Dibujar tres líneas verticales
    for (var i = 0; i < 3; i++) {
        ctx.moveTo(inicio_x + i * 13 + 7, inicio_y); // Ajusta el valor 5 para mover más a la derecha
        ctx.lineTo(inicio_x + i * 13 + 7, inicio_y + 40); // Ajusta el valor 5 para mover más a la derecha
    }

    ctx.stroke();
    ctx.lineWidth = 1;
}
// Función para marcar ausencia con una "X"
function marcar_ausencia(contexto, num_diente, color_pas) {
    var ctx = contexto;
    var med = 40; // Asegúrate de tener definida la variable med
    var separacion_x = 10; // Asegúrate de tener definida la variable separacion_x

    num_diente = num_diente - 1;
    color_line = color_pas;

    var inicio_y;
    if (num_diente < 16) {
        inicio_y = 20;
    } else {
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }

    var inicio_x = (num_diente * med) + (separacion_x * num_diente) + separacion_x;

    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.lineWidth = 3;

    // Dibujar una "X" en el centro del cuadrado
    console.log('pipipi')
    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.lineWidth = 3;
    ctx.moveTo(inicio_x, inicio_y);
    ctx.lineTo(inicio_x + 40, inicio_y + 40);
    ctx.moveTo(inicio_x + 40, inicio_y);
    ctx.lineTo(inicio_x, inicio_y + 40);
    ctx.stroke();
    ctx.lineWidth = 1;

}

// Funcion para marcar puente
function marcar_puente(contexto, dient_1, dient_2, color_pas) {
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente1 = dient_1 - 1;
    num_diente2 = dient_2 - 1;
    color_line = color_pas;
    if (num_diente1 < 16) {
        inicio_y = 80;
    } else {
        num_diente1 = num_diente1 - 16;
        num_diente2 = num_diente2 - 16;
        inicio_y = med + 160;
    }
    //swal.fire(num_diente);
    inicio_x = (num_diente1 * med) + (separacion_x * num_diente1) + separacion_x + (med / 2);
    fin_x = (num_diente2 * med) + (separacion_x * num_diente2) + separacion_x + (med / 2);
    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.lineWidth = 4;
    ctx.moveTo(inicio_x, inicio_y);
    ctx.lineTo(fin_x, inicio_y);
    //ctx.moveTo(inicio_x+40,inicio_y);
    //ctx.lineTo(inicio_x,inicio_y+40);
    ctx.stroke();
    ctx.lineWidth = 1;
}

// Funcion para marcar puente
function borrar_diente(contexto, num_diente) {
    ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente = num_diente - 1;
    if (num_diente < 16) {
        inicio_y = 20;
    } else {
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }
    //swal.fire(num_diente);
    inicio_x = (num_diente * med) + (separacion_x * num_diente) + separacion_x;
    ctx.clearRect(inicio_x, inicio_y, med, med);
}

// Valores iniciales
var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');
//
var layer2 = document.getElementById("myCanvas2");
var ctx2 = layer2.getContext("2d");
//
var layer3 = document.getElementById("myCanvas3");
var ctx3 = layer3.getContext("2d");
//
var layer4 = document.getElementById("myCanvas4");
var ctx4 = layer4.getContext("2d");
//
var color_line = 'black';
var medida = 40;
var separacion_x = 10;
var separacion_y = 10;
var iniciar_x = 0;
var iniciar_y = 20;
//Dientes para el puente
var diente1 = 0;
var diente2 = 0;
// 1 - 16 dientes
const customNumbers = [55, 54, 53, 52, 51, 61, 62, 63, 64, 65];

// 1 - 16 dientes
for (let x = 0; x < customNumbers.length; x++) {
    const iniciar_x = x * (medida + separacion_x) + separacion_x;
    dibuja_contorno(context, iniciar_x, iniciar_y, medida, separacion_x, 10);

    context.font = '10pt Calibri';
    context.textAlign = 'center';
    context.fillStyle = 'black';
    context.fillText(customNumbers[x], iniciar_x + medida / 2, iniciar_y / 2 + 5);
}
// 17 - 32 dientes
iniciar_x = 0;
iniciar_y = medida + 100;
const customNumbersSecondRow = [85, 84, 83, 82, 81, 71, 72, 73, 74, 75];

for (let x = 0; x < customNumbersSecondRow.length; x++) {
    const currentNumber = customNumbersSecondRow[x];
    const secondRowX = x * (medida + separacion_x) + separacion_x;
    const secondRowY = iniciar_y;

    dibuja_contorno(context, secondRowX, secondRowY, medida, separacion_x, 10);

    context.font = '10pt Calibri';
    context.textAlign = 'center';
    context.fillStyle = 'black';
    context.fillText(currentNumber, secondRowX + medida / 2, secondRowY - 10 + 5);
}
//dibuja_seccion(context, 2, 3, 'red');
//dibuja_seccion(context, 18, 5, 'green');
//dibuja_seccion(context, 24, 4, 'blue');
window.onload = function() {
    const activeTheme = localStorage.getItem("theme");
    localStorage.clear();
    localStorage.setItem('theme',activeTheme);
    click();
}

function click() {
    //Añadimos un addEventListener al canvas para reconocer el click
    layer4.addEventListener("click",
        //Una vez se haya clickado se activará la siguiente función
        getPosition, false);
    layer4.addEventListener("mousemove", Marcar, false);
}
//canvas.addEventListener("mousedown", getPosition, false);
var caries = 0;
    var restauraciones = 0;
    var extracciones = 0;
    var ausencias = 0;
    var puentes = 0;
    var endodoncias = 0;
    var implantes = 0;
function getPosition(event) {
    var x = event.x;
    var y = event.y;
    //swal.fire(y);
    //swal.fire(x);
    var canvas = document.getElementById("myCanvas");
    var div_can = document.getElementById("canvasesdiv");
    x -= div_can.offsetLeft;
    y -= div_can.offsetTop;
    //swal.fire(div_can.offsetTop);
    var div = 0;
    var color = '';
    var accion = '';
    let seleccion = $("input[name='accion']:checked").val();
    if (seleccion == 'fractura') {
        color = 'red';
        accion = 'seccion';
        caries = caries + 1;
        console.log(caries);
    } else if (seleccion == 'restauracion') {
        color = 'blue';
        accion = 'seccion';
        restauraciones = restauraciones + 1;
        console.log(restauraciones);
    } else if (seleccion == 'extraccion') {
        color = 'black';
        accion = 'marcar';
        extracciones = extracciones + 1;
        console.log(extracciones);
    } else if (seleccion == 'ausencia') {
        color = 'black';
        accion = 'marcar';
        ausencias = ausencias + 1;
        console.log(ausencias);
    } else if (seleccion == 'puente') {
        accion = 'puente';
        puentes = puentes + 1;
        console.log(puentes);
    } else if (seleccion == 'Endodoncia') {
        color = 'green';
        accion = 'seccion';
        endodoncias = endodoncias + 1;
        console.log(endodoncias);
    } else if (seleccion == 'Implante') {
        color = 'yellow';
        accion = 'seccion';
        implantes = implantes + 1;
        console.log(implantes);
    } else if (seleccion == 'borrar') {
        accion = 'borrar';
    }
    //swal.fire(y);
    diente = 0;
    seccion = 0;
    if (y >= 20 && y <= 60) {
        //swal.fire(x);
        if (x >= 10 && x <= 50) {
            diente = 1;
        } else if (x >= 60 && x <= 800) {
            div = parseInt(x / 50, 10);
            ini = (div * 40) + (10 * div) + 10;
            fin = ini + 40;
            if (x >= ini && x <= fin) {
                diente = div + 1;
            }
        }
    } else if (y >= 140 && y <= 180) {
        if (x >= 10 && x <= 50) {
            diente = 17;
        } else if (x >= 60 && x <= 800) {
            div = parseInt(x / 50, 10);
            ini = (div * 40) + (10 * div) + 10;
            fin = ini + 40;
            if (x >= ini && x <= fin) {
                diente = div + 17;
            }
        }
    }
    if (diente) {
        //swal.fire(diente);
        if (accion == 'seccion') {
            x = x - ((div * 40) + (10 * div) + 10);
            y = y - 20;
            if (diente > 16) {
                y = y - 120;
            }
            //swal.fire(y);
            if (y > 0 && y < 10 && x > y && y < 40 - x) {
                seccion = 1;
            } else if (x > 30 && x < 40 && y < x && 40 - x < y) {
                seccion = 2;
            } else if (y > 30 && y < 40 && x < y && x > 40 - y) {
                seccion = 3;
            } else if (x > 0 && x < 10 && y > x && x < 40 - y) {
                seccion = 4;
            } else if (x > 10 && x < 30 && y > 10 && y < 30) {
                seccion = 5;
            }
        } else if (accion == 'marcar') {
            cod = diente + '-0-' + '3';
            if (cod && !localStorage.getItem(cod)) {
                new_array = [diente, 0, 3, Date.now(), 0];
                guardar = new_array.toLocaleString();
                localStorage.setItem(cod, guardar);
                if (seleccion == 'ausencia') {
                    marcar_ausencia(ctx2, diente, 'black');
                } else {
                    marcar_extraccion(ctx2, diente, 'black');
                }


            } else {
                swal.fire("Ya fue marcado");
            }

        } else if (accion == 'puente') {
            if (diente1 == 0) {
                marcar_diente(ctx4, diente, 'red');
                diente1 = diente;
            } else if (diente2 == 0) {
                diente2 = diente;
                menor = 0;
                mayor = 0;
                if (diente1 > diente2) {
                    mayor = diente1;
                    menor = diente2;
                } else {
                    mayor = diente2;
                    menor = diente1
                }
                diente1 = menor;
                diente2 = mayor;
                if ((diente1 < 17 && diente2 < 17 && diente1 != diente2) || (diente1 > 17 && diente2 > 17 && diente1 !=
                        diente2)) {
                    marcar_diente(ctx4, diente, 'red');
                    ctx4.clearRect(0, 0, 810, 70);
                    ctx4.clearRect(0, 135, 810, 70);
                    cod = diente1 + '-0-4-' + diente2;
                    if (cod && !localStorage.getItem(cod)) {
                        new_array = [diente1, 0, 4, Date.now(), diente2];
                        guardar = new_array.toLocaleString();
                        localStorage.setItem(cod, guardar);
                    } else {
                        swal.fire("Ya fue marcado");
                    }
                    marcar_puente(ctx4, diente1, diente2, 'red');
                } else {
                    ctx4.clearRect(0, 0, 810, 70);
                    ctx4.clearRect(0, 135, 810, 70);
                }

                diente1 = 0;
                diente2 = 0;
            }

        } else if (accion == 'borrar') {
            borrar_diente(ctx2, diente);
            //cargar el ultimo pintado
            seccion_chk = $("input[name='seccion']:checked").val();
            if (seccion_chk == 'seccion') {
                x = x - ((div * 40) + (10 * div) + 10);
                y = y - 20;
                if (diente > 16) {
                    y = y - 120;
                }
                seccion_b = ubica_seccion(x, y);
                if (seccion_b) {
                    ultimo = '';
                    key_cod = '';
                    for (var i = 0; i < localStorage.length; i++) {
                        var key_name = localStorage.key(i);
                        item = localStorage.getItem(key_name);
                        item = item.split(',');
                        diente_comp = parseInt(item[0], 10);
                        seccion_comp = parseInt(item[1], 10);
                        accion_comp = parseInt(item[2], 10);
                        if (diente_comp == diente && seccion_b == seccion_comp && (accion_comp == 1 || accion_comp ==
                                2)) {
                            if (ultimo == '') {
                                ultimo = item;
                                key_cod = key_name;
                            } else {
                                fecha_ult = parseInt(item[3], 10);
                                if (ultimo[3] < fecha_ult) {
                                    ultimo = item;
                                    key_cod = key_name;
                                }
                            }
                        }
                    }
                    if (key_cod != '') {
                        //console.log(key_cod);
                        localStorage.removeItem(key_cod);
                    }
                }

            } else if (seccion_chk == 'diente') {
                ultimo = '';
                key_cod = '';
                for (var i = 0; i < localStorage.length; i++) {
                    var key_name = localStorage.key(i);
                    item = localStorage.getItem(key_name);
                    item = item.split(',');
                    diente_comp = parseInt(item[0], 10);
                    accion_comp = parseInt(item[2], 10);
                    if (diente_comp == diente && accion_comp == 3) {
                        if (ultimo == '') {
                            ultimo = item;
                            key_cod = key_name;
                        } else {
                            fecha_ult = parseInt(item[3], 10);
                            if (ultimo[3] < fecha_ult) {
                                ultimo = item;
                                key_cod = key_name;
                            }
                        }
                    }
                }
                if (key_cod != '') {
                    //console.log(key_cod);
                    localStorage.removeItem(key_cod);
                }
            }
            //swal.fire('a');
            pinta_datos();
        }
    }
    //swal.fire(diente);
    if (seccion && color != '') {
        //swal.fire(color);

        //swal.fire(seccion);
        //[numero_diente, seccion, accion, fecha, diente2]
        if (color == 'red') {
            cod = diente + '-' + seccion + '-' + '1';
            accion_g = 1;
        } else if (color == 'blue') {
            cod = diente + '-' + seccion + '-' + '2';
            accion_g = 2;
        } else if (color == 'green') {
            cod = diente + '-' + seccion + '-' + '2';
            accion_g = 2;
        } else if (color == 'yellow') {
            cod = diente + '-' + seccion + '-' + '2';
            accion_g = 2;
        };
        if (cod && !localStorage.getItem(cod)) {
            new_array = [diente, seccion, accion_g, Date.now(), 0];
            guardar = new_array.toLocaleString();
            localStorage.setItem(cod, guardar);
            dibuja_seccion(ctx2, diente, seccion, color);
        } else {
            swal.fire("ya fue marcado");
        }

    }
    if ('borrar' == $("input[name='accion']:checked").val()) {
        //swal.fire("x-> "+x+" y-> "+y);
        //ctx4.clearRect(0, 0, 810, 300);

        if (x >= 30 && x <= 780 && ((y > 78 && y < 82) || (y > 198 && y < 202))) {
            //swal.fire(x);
            div = parseInt(x / 50, 10);
            //swal.fire(div);
            ultimo = '';
            key_cod = '';
            for (var i = 0; i < localStorage.length; i++) {
                var key_name = localStorage.key(i);
                item = localStorage.getItem(key_name);
                item = item.split(',');
                diente1_comp = parseInt(item[0], 10);
                diente2_comp = parseInt(item[4], 10);
                accion_comp = parseInt(item[2], 10);
                if (accion_comp == 4) {
                    if (diente1_comp > 16) {
                        diente1_comp = diente1_comp - 17;
                        diente2_comp = diente2_comp - 17;
                    } else {
                        diente1_comp = diente1_comp - 1;
                        diente2_comp = diente2_comp - 1;
                    }
                    inicio_x = (diente1_comp * 40) + (10 * diente1_comp) + 10 + 20;
                    fin_X = (diente2_comp * 40) + (10 * diente2_comp) + 10 + 20;
                    if (x >= inicio_x && x <= fin_x) {
                        if (ultimo == '') {
                            ultimo = item;
                            key_cod = key_name;
                        } else {
                            fecha_ult = parseInt(item[3], 10);
                            if (ultimo[3] < fecha_ult) {
                                ultimo = item;
                                key_cod = key_name;
                            }
                        }
                    }

                }
            }
            if (key_cod != '') {
                console.log(key_cod);
                if (parseInt(ultimo[0], 10) < 16) {
                    seccion_p = 1;
                    ctx4.clearRect(0, 0, 810, 130);
                } else {
                    ctx4.clearRect(0, 130, 810, 150);
                    seccion_p = 2;
                }
                localStorage.removeItem(key_cod);
                pinta_puentes(seccion_p);
            }
        }

    }

}

//dibuja_seccion(x, y, 5, 5);
//dibuja_seccion(context, num_diente, seccion, color)


function Marcar(event) {
    var x = event.x;
    var y = event.y;
    var canvas2 = document.getElementById("myCanvas2");
    var div_can = document.getElementById("canvasesdiv");
    x -= div_can.offsetLeft;
    y -= div_can.offsetTop;
    //swal.fire(x);
    diente = 0;
    seccion = 0;
    var div = 0;

    if (y >= 20 && y <= 60) {
        //swal.fire(x);
        if (x >= 10 && x <= 50) {
            diente = 1;
            //swal.fire("1");
        } else if (x >= 60 && x <= 800) {
            div = parseInt(x / 50, 10);
            ini = (div * 40) + (10 * div) + 10;
            fin = ini + 40;
            if (x >= ini && x <= fin) {
                diente = div + 1;
            }
        }
    } else if (y >= 140 && y <= 180) {
        if (x >= 10 && x <= 50) {
            diente = 17;
        } else if (x >= 60 && x <= 800) {
            div = parseInt(x / 50, 10);
            ini = (div * 40) + (10 * div) + 10;
            fin = ini + 40;
            if (x >= ini && x <= fin) {
                diente = div + 17;
            }
        }
    }
    //swal.fire(diente);
    if (diente) {
        accion = $("input[name='accion']:checked").val();
        var seleccion = '';
        if (accion == 'fractura') {
            seleccion = 'seccion';
        } else if (accion == 'restauracion') {
            seleccion = 'seccion';
        } else if (accion == 'Endodoncia') {
            color = 'green';
            seleccion = 'seccion';
        } else if (accion == 'Implante') {
            color = 'yellow';
            seleccion = 'seccion';
        } else if (accion == 'extraccion') {
            seleccion = 'diente';
        } else if (accion == 'ausencia') {
            seleccion = 'diente';
        } else if (accion == 'puente') {
            seleccion = 'diente';
        } else if (accion == 'borrar') {
            seccion_chk = $("input[name='seccion']:checked").val();
            if (seccion_chk == 'diente') {
                seleccion = 'diente';
            } else {
                seleccion = 'seccion';
            }
        }
        if (seleccion == 'seccion') {
            x = x - ((div * 40) + (10 * div) + 10);
            y = y - 20;
            if (diente > 16) {
                y = y - 120;
            }
            //swal.fire(y);
            /*if (y>=x && y<=39){}*/
            // Ubicar la seccion clickeada
            if (y > 0 && y < 10 && x > y && y < 40 - x) {
                seccion = 1;
            } else if (x > 30 && x < 40 && y < x && 40 - x < y) {
                seccion = 2;
            } else if (y > 30 && y < 40 && x < y && x > 40 - y) {
                seccion = 3;
            } else if (x > 0 && x < 10 && y > x && x < 40 - y) {
                seccion = 4;
            } else if (x > 10 && x < 30 && y > 10 && y < 30) {
                seccion = 5;
            }
            //Comprobacion de si eta en una seccion
            if (seccion) {
                //swal.fire(seccion);
                color = 'yellow';
                ctx3.clearRect(0, 0, 810, 300);
                marcar_seccion(ctx3, diente, seccion, color);
                //swal.fire(seccion);
            } else {
                //ctx2.fillStyle = "white";
                //ctx2.fillRect(0, 0, 810, 300);
                ctx3.clearRect(0, 0, 810, 300);
            }
        } else if (seleccion == 'diente') {
            ctx3.clearRect(0, 0, 810, 300);
            marcar_diente(ctx3, diente, 'yellow');
        }
    } else {
        ctx3.clearRect(0, 0, 810, 300);
    }

    //dibuja_contorno(canvas, inicio_x, inicio_y, med, separacion_x, separacion_y)
}

function pinta_datos() {
    array_local = [];
    for (var i = 0; i < localStorage.length; i++) {
        var key_name = localStorage.key(i);
        array_local[i] = localStorage.getItem(key_name).split(',');
    }
    array_local.sort(function(a, b) {
        return a[3] > b[3]; // orden ascendente por las fechas;
    });

    for (var i = 0; i < array_local.length; i++) {
        item = array_local[i];
        if (parseInt(item[0], 10) == diente) {
            acc = parseInt(item[2], 10);
            if (acc == 1) {
                color = 'red';
                dibuja_seccion(ctx2, item[0], item[1], color);
            } else if (acc == 2) {
                color = 'blue';
                dibuja_seccion(ctx2, item[0], item[1], color);
            } else if (acc == 3) {
                marcar_ausencia(ctx2, item[0], 'black');
            } else if (acc = 6) {
                color = 'green';
                dibuja_seccion(ctx2, item[0], item[1], color);
            } else if (acc = 8) {
                color = 'yellow';
                dibuja_seccion(ctx2, item[0], item[1], color);
            }


        }
    }
}
function saveDataToBackend(data, id) {
    html2canvas(document.querySelector("#canvasesdiv")).then(canvas => {
        var dataURL = canvas.toDataURL('image/png'); 
        data.image = dataURL;

        axios.post(`/odontograph/update/${id}`, {
            _token: '{{ csrf_token() }}',  
            ...data
        })
        .then(response => {
            Swal.fire({
                icon: "success",
                title: "Éxito",
                text: "Odontograma actualizado correctamente."
            });
            const odontodiagram_id = response.data.odontodiagram_id;

            setTimeout(() => {
                window.location.href = '{{route('odontograph.index')}}';
            }, 1000);
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'Hubo un error al actualizar el Odontograma. ' +
                      (error.response && error.response.data.error ? error.response.data.error : 'Error desconocido'),
                footer: `Error: ${error.message}`
            });
        });
    });
}
saveButton.addEventListener('click', function () {
    var dataToSave = {
        patient_id: {{ $pacient->pacient_id }},
        caries: caries,
        restauraciones: restauraciones,
        extracciones: extracciones,
        ausencias: ausencias,
        puentes: puentes,
        endodoncias: endodoncias,
        implantes: implantes
    };

    const odontodiagramId = {{ $odontodiagram->id }}; // Asegúrate de que esta línea obtenga un ID válido
  
    // Llama a la función para guardar los datos y generar la imagen
    saveDataToBackend(dataToSave, odontodiagramId); // Pasa el ID a la función
});
function pinta_puentes(seccion_p) {
    array_local = [];
    for (var i = 0; i < localStorage.length; i++) {
        var key_name = localStorage.key(i);
        array_local[i] = localStorage.getItem(key_name).split(',');
    }
    //console.log(array_local);
    array_local.sort(function(a, b) {
        return a[3] > b[3]; // orden ascendente por las fechas;
    });
    //console.log(array_local);
    for (var i = 0; i < array_local.length; i++) {
        item = array_local[i];
        acc = parseInt(item[2], 10);
        //console.log(acc);
        if (acc == 4) {
            color_pas = 'red';
            if (seccion_p == 1) {
                if (parseInt(item[0], 10) < 17) {
                    marcar_puente(ctx4, item[0], item[4], color_pas);
                }
            } else {
                if (parseInt(item[0], 10) > 16) {
                    marcar_puente(ctx4, item[0], item[4], color_pas);
                }
            }
            //dibuja_seccion(ctx2, item[0], item[1], color);
        }

    }
}

function ubica_seccion(X, Y) {
    y = Y;
    x = X;
    devolver_seccion = 0;
    if (y > 0 && y < 10 && x > y && y < 40 - x) {
        devolver_seccion = 1;
    } else if (x > 30 && x < 40 && y < x && 40 - x < y) {
        devolver_seccion = 2;
    } else if (y > 30 && y < 40 && x < y && x > 40 - y) {
        devolver_seccion = 3;
    } else if (x > 0 && x < 10 && y > x && x < 40 - y) {
        devolver_seccion = 4;
    } else if (x > 10 && x < 30 && y > 10 && y < 30) {
        devolver_seccion = 5;
    }
    return devolver_seccion;
}
</script>

@endsection