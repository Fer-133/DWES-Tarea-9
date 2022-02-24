<?php
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.

/**
 * Crea una conexion con la base de datos libros y la devuelve
 * @return object Se devuelve el objeto de la base de datos y si ha habido algun error devuelve null
 */
function conexion(){
  $servidor = "localhost";
  $usuario = "otro";
  $contrasenia = "otro";
  $base = "libros";
  @$mysqli = new mysqli($servidor, $usuario, $contrasenia, $base);
  if($mysqli->connect_errno){
      return null;
  } else {
      $mysqli->set_charset("utf8");
      return $mysqli;
  }
}

/**
 * Devuelve los datos de los autores y la lista de libros que han escrito
 * @param string $nombre nombre o parte del nombre del autor/autores del que se quiere obtener la información
 * @return array Se devuelve un array con el nombre, apellidos y titulo de sus libros
 */
function get_datos_autores($nombre) {
    $mysqli = conexion();
        
    $i = 0;
    $sql = "SELECT id, nombre, apellidos FROM autor WHERE nombre LIKE '%$nombre%' OR apellidos LIKE '%$nombre%' ORDER BY nombre";
    $resultset = $mysqli->query($sql);    
    if ($resultset->num_rows > 0 && !$mysqli->error) {      
      while ($fila = $resultset->fetch_array()) {                       
        $info_autor[]["datos"] = array ("id" => $fila["id"], "nombre" => $fila["nombre"], "apellidos" => $fila["apellidos"]);
        
        $id = $info_autor[$i]["datos"]["id"];        
        $sql = "SELECT titulo FROM libro WHERE id_autor = $id";        
        $resultset2 = $mysqli->query($sql);            
        if ($resultset2->num_rows > 0 && !$mysqli->error) {
          while ($fila = $resultset2->fetch_array()) {
            $info_autor[$i]["datos"]["libros"][] = array ("titulo" => $fila["titulo"]);
          }
        }          
        $i++;        
      }          
    } else {
      $info_autor = null;
    }
    return $info_autor;
}

$devolver = "";
if (isset($_GET["nombre"])) {
  $nombre = $_GET["nombre"];
  $info_autores = get_datos_autores($nombre);

  if ($info_autores){
    foreach ($info_autores as $autor){
      
      $devolver = $devolver . "<h2 class='autor'>Autor: </h2>" . $autor["datos"]["nombre"] .
       " " . $autor["datos"]["apellidos"] . "<br>" . "<h3 class='libros'>Libros: </h3><ul>";

      foreach ($autor["datos"]["libros"] as $libro) {
        $devolver = $devolver . "<li>" . $libro["titulo"] . "</li>";
      }
      $devolver = $devolver . "</ul><hr><br>";
    }
  } else {
    $devolver = "Autor no encontrado";
  }  
}
echo $devolver;

?>
