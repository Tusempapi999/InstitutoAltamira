<?php
    include('clases/claseAlumno.php'); // Se incluye el archivo de la clase Alumno
    $alumno = new Alumno(); // Se crea una instancia de la clase Alumno
    $alumno_id = $_GET['alumno_id']; // Se obtiene el alumno_id enviado por el formulario
    $resultado = $alumno->setCalificacion($alumno_id); // Se llama a la función setCalificacion con el alumno_id
    if ($resultado->num_rows > 0) { // Si el resultado tiene más de 0 filas
        echo "<h2>Tus calificaciones</h2>";
        echo "<table>";
        echo "<thead><tr><th>Asignatura</th><th>Calificacion</th></tr></thead>";
        echo "<tbody>";
        while ($datos=$resultado->fetch_assoc()) { // Recorre el resultado
            echo "<tr>";
            echo "<td>".$datos['asignatura']."</td>";
            echo "<td>".$datos['calificacion']."</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No se encontraron sus calificaciones";
    }
?>
