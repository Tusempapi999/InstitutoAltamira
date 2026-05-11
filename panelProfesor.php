<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Maestro </title>
    <link rel="stylesheet" href="visual_maestro.css">

</head>
<body>

<div class="contenedor">

    <!-- Barra lateral -->
    <aside class="sidebar">
        <div class="logo">
            Colegio<br><span>Nuevo Futuro</span>
        </div>

        <nav class="menu-lateral">
            <a href="listarAlumnos.php?alumno_id=1">Listar alumnos de clase</a>
            <a href="listarProfesores.php?alumno_id=1">Listar profesores</a>
            <a href="-">Calificaciones</a>
            <a href="-">Asistencia</a>
        </nav>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="contenido">

        <!-- BARRA SUPERIOR -->
        <header class="barra-superior">

            <span><h2>Bienvenido al panel del Maestro</h2></span>

            <!-- PERFIL -->
            <div class="perfil">
                <span class="nombre">---</span>
                <div class="circulo"></div>

                <!-- MENÚ DESPLEGABLE -->
                <div class="menu">
                    <div class="notificaciones">
                        Notificaciones
                    </div>        
                    <a href="#">Configuración</a>
                    <a href="#">Ayuda</a>
                    <a href="pruebaConsultas.html" class="salir">Finalizar sesión</a>
                </div>
            </div>

        </header>

        <!-- PANEL VACÍO -->
        <div class="panel-vacio">
            <tbody>
                <tr>
                    <td>id</td>
                    <td>nombre</td>
                    <td>email</td>
                    <td>rol</td>
                    <td>fecha_nacimiento</td>
                </tr>
    
            </tbody>
        </div>

    </main>

</div>

</body>
</html>
        