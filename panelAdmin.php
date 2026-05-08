<meta charset="UTF-8">

<h1>Usuarios</h1>

<!-- Subtítulo del menú -->
<h2>Menu</h2>

<!-- Lista de opciones del sistema -->
<ul>
    <!-- Enlace para dar de alta una asignatura (envía opcion=alta por GET) -->
    <li>
        <a href="?opcion=altaUser">Alta usuario</a>
    </li>

    <!-- Enlace para eliminar una asignatura -->
    <li>
        <a href="?opcion=bajaUser">Baja usuario</a>
    </li>

    <!-- Enlace para modificar una asignatura -->
    <li>
        <a href="?opcion=modificarUser">Modificar usuario</a>
    </li>

    <!-- Enlace para listar todas las asignaturas -->
    <li>
        <a href="?opcion=listarUser">Listar usuarios</a>
    </li>
</ul>

<?php

include('clases/claseAdmin.php'); // Se incluye el archivo de la clase admin

$admin = new Admin(); // Se crea una instancia de la clase admin

if(isset($_GET['opcion']) && $_GET['opcion'] == "altaUser"){
    ?>
    <h2>Registrar un nuevo usuario</h2>
    
    <form method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" placeholder="Nombre" required><br><br>
        <label for="email">Email:</label><br>
        <input type="text" name="email" placeholder="Email" required><br><br>
        <label for="pwd">Contraseña:</label><br>
        <input type="text" name="pwd" placeholder="Contraseña" required><br><br>
        <label for="fecha_nacimiento">Fecha de nacimiento:</label><br>
        <input type="date" name="fecha_nacimiento" placeholder="Fecha de nacimiento" required><br><br>
        <label for="rol">Rol:</label><br>
        <select name="rol" required>
            <option value="admin">Admin</option>
            <option value="alumno">Alumno</option>
            <option value="profesor">Profesor</option>
        </select><br><br>
        <input type="submit" name="guardarUser" value="Guardar usuario">
    </form>
    <?php
}
    if(isset($_POST['guardarUser'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $rol = $_POST['rol'];

        // Aquí deberías llamar a un método de la clase admin para guardar el nuevo usuario
        // Por ejemplo: $admin->agregar_usuario($nombre, $email, $pwd, $fecha_nacimiento, $rol);
        $resultado = $admin->agregar_usuario($nombre, $email, $pwd, $fecha_nacimiento, $rol);
        if($resultado){
            echo "Usuario guardado";
        }else{
            echo "No se pudo guardar el usuario";
        }
    }

    if(isset($_GET['opcion']) && $_GET['opcion'] == "listarUser"){
        $resultado = $admin->listarUsuarios(); // Deberías implementar este método en la clase admin
        echo "<h2>Usuarios Registrados</h2>";
        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Fecha de nacimiento</th>
            </tr>";
        while($fila = $resultado->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$fila['id']."</td>";
            echo "<td>".$fila['nombre']."</td>";
            echo "<td>".$fila['email']."</td>";
            echo "<td>".$fila['rol']."</td>";
            echo "<td>".$fila['fecha_nacimiento']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    if(isset($_GET['opcion']) && $_GET['opcion'] == "bajaUser"){
        // Aquí iría el formulario para eliminar un usuario
        ?>
        <h2>Eliminar usuario</h2>
        <form method="post">
            <label for="id">Matricula del usuario a eliminar:</label><br>
            <input type="text" name="id" placeholder="Matricula del usuario" required><br><br>
            <input type="submit" name="eliminarUser" value="Eliminar usuario">
        </form>
        <?php
        if(isset($_POST['eliminarUser'])) {
            $id = $_POST['id'];
            // Aquí deberías llamar a un método de la clase admin para eliminar el usuario
            // Por ejemplo: $admin->eliminar_usuario($id);
            $resultado = $admin->eliminar_usuario($id);
            if($resultado){
                echo "Usuario eliminado";
            }else{
                echo "No se pudo eliminar el usuario";
            }
        }
    }

    if(isset($_GET['opcion']) && $_GET['opcion'] == "modificarUser"){
        // Aquí iría el formulario para modificar un usuario
        ?>
        <h2>Modificar usuario</h2>
        <form method="post">
            <label for="id">Matricula del usuario a modificar:</label><br>
            <input type="text" name="id" placeholder="Matricula del usuario" required><br><br>
            <label for="nombre">Nuevo nombre:</label><br>
            <input type="text" name="nombre" placeholder="Nuevo nombre"><br><br>
            <label for="email">Nuevo email:</label><br>
            <input type="text" name="email" placeholder="Nuevo email"><br><br>
            <label for="pwd">Nueva contraseña:</label><br>
            <input type="text" name="pwd" placeholder="Nueva contraseña" required><br><br>
            <label for="fecha_nacimiento">Nueva fecha de nacimiento:</label><br>
            <input type="date" name="fecha_nacimiento" placeholder="Nueva fecha de nacimiento"><br><br>
            <label for="rol">Nuevo rol:</label><br>
            <select name="rol">
                <option value="admin" selected>Admin</option>
                <option value="alumno">Alumno</option>
                <option value="profesor">Profesor</option>
            </select><br><br>
            <input type="submit" name="modificarUser" value="Modificar usuario">
        </form>
        <?php
        if(isset($_POST['modificarUser'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $rol = $_POST['rol'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            // Aquí deberías llamar a un método de la clase admin para modificar el usuario
            // Por ejemplo: $admin->modificar_usuario($id, $pwd);
            $resultado = $admin->modificar_usuario($id, $nombre, $email, $pwd, $rol, $fecha_nacimiento);
            if($resultado){
                echo "Usuario modificado";
            }else{
                echo "No se pudo modificar el usuario";
            }
        }
    }

    
?>