<!DOCTYPE html>
<html>
    <head>
        <title>Tarea 9</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script>            
            $(document).ready(function(){
                $("#nombre").keyup(function(){                    
                    if(/^\D+$/.test($("#nombre").val())){
                        $("#error").html("");                        
                        $("#resultados").load("api.php?nombre=" + $("#nombre").val());
                        $("#resultados").addClass("resultados");                     
                    } else {
                        $("#error").html("Error: Solo se aceptan letras");
                        $("#resultados").removeClass("resultados");
                        $("#resultados").html("");
                    }                    
                });
            });
        </script>     
        <style>
            @import url(estilo.css);
        </style>   
    </head>
    <body>
        <h1>Buscadores</h1>
        <nav>
            <ul>
                <li><a href="cliente.php">Buscador de autores</a></li>
                <li><a href="pokemon.php">Buscador de pokemons</a></li>
            </ul>
        </nav>   
        <h3 class="seccion">Buscar Autor:</h3>    
        <div>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
                <label for="nombre">Nombre del autor: </label>
                <input id="nombre" name="nombre" type="text">
                <p id="error"></p>
            </form>
            <h4>Resultados:</h4>
            <div id="resultados" ></div>
        </div>
    </body>
</html>