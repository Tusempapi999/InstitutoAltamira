DROP DATABASE IF EXISTS Altamira; -- si existe una base de datos con el mismo nombre la eleminamos
CREATE DATABASE Altamira;
USE Altamira;

CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'alumno', 'profesor') NOT NULL DEFAULT 'alumno',
    fecha_nacimiento DATE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);
-- La tabla anterior es la tabla del usuario, en la primera linea encontramos el campo id
-- que se incrementa automáticamente con AUTO_INCREMENT, este campo también es la clave primaria
-- seguido esta el email que con UNIQUE decimos que es unico, no se puede repertir dos correos en la BD
-- pwd (password) es la contraseña la cual tampoco puede ser nula (NOT NULL)
-- en rol la palabra ENUM nos permite definir una lista de valores esclusivos para este campo
-- es decir que solo puede tomar los valores 'admin', 'alumno' o 'profesor' y asigna alumno por defecto
-- este campo podemos retornar su valor como string o como numero.

CREATE TABLE alumno (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL, 
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);

CREATE TABLE profesor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    especialidad VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);

CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    departamento VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);

CREATE TABLE justificante (
    id INT PRIMARY KEY AUTO_INCREMENT,
    alumno_id INT NOT NULL,
    fecha DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('pendiente', 'aceptado', 'rechazado') DEFAULT 'pendiente',
    FOREIGN KEY (alumno_id) REFERENCES alumno(id) ON DELETE CASCADE
);

CREATE TABLE aula (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE asignatura (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- 2. NUEVA TABLA: Grupo (Reemplaza a 'imparte' y absorbe grado/grupo)
-- Esta tabla representa la clase física que da un profesor.
CREATE TABLE grupo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    asignatura_id INT NOT NULL,
    profesor_id INT NOT NULL,
    grado CHAR(1) NOT NULL,
    letra_grupo CHAR(1) NOT NULL, -- Ej: 'A', 'B'
    FOREIGN KEY (asignatura_id) REFERENCES asignatura(id) ON DELETE CASCADE,
    FOREIGN KEY (profesor_id) REFERENCES profesor(id) ON DELETE CASCADE
);

-- 3. Matriculado ahora une al alumno con el GRUPO (no con la asignatura suelta)
CREATE TABLE matriculado (
    id INT PRIMARY KEY AUTO_INCREMENT,
    alumno_id INT NOT NULL,
    grupo_id INT NOT NULL, -- El alumno se inscribe a un grupo específico
    calificacion DECIMAL(3,1),
    faltas INT DEFAULT 0,  -- Las faltas van aquí
    FOREIGN KEY (alumno_id) REFERENCES alumno(id) ON DELETE CASCADE,
    FOREIGN KEY (grupo_id) REFERENCES grupo(id) ON DELETE CASCADE
);

-- 4. Horario se asigna al GRUPO, no al alumno matriculado
CREATE TABLE horario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    grupo_id INT NOT NULL, -- El horario es para todo el grupo
    aula_id INT NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    FOREIGN KEY (grupo_id) REFERENCES grupo(id) ON DELETE CASCADE,
    FOREIGN KEY (aula_id) REFERENCES aula(id) ON DELETE CASCADE
);

CREATE TABLE asistencia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matriculado_id INT NOT NULL, -- Esto ya vincula al alumno con la materia/grupo exacto
    fecha DATE NOT NULL,
    estado ENUM('presente', 'ausente', 'retardo', 'justificado') NOT NULL DEFAULT 'presente',
    FOREIGN KEY (matriculado_id) REFERENCES matriculado(id) ON DELETE CASCADE,
    UNIQUE (matriculado_id, fecha) -- ¡Clave! Esto evita pasarle lista dos veces al mismo alumno el mismo día
);

-- 1. Catálogo de los clubes disponibles
CREATE TABLE club (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    profesor_id INT, -- Opcional, si un profe lo coordina
    aula_id INT,     -- Opcional, si tienen un lugar fijo
    hora_inicio TIME,
    hora_fin TIME,
    cupo_maximo INT,
    FOREIGN KEY (profesor_id) REFERENCES profesor(id) ON DELETE SET NULL,
    FOREIGN KEY (aula_id) REFERENCES aula(id) ON DELETE SET NULL
);

-- 2. Inscripción al club
CREATE TABLE inscripcion_club (
    alumno_id INT PRIMARY KEY, -- ¡MAGIA AQUÍ! Al ser Primary Key, el alumno NO puede aparecer dos veces. Solo un club.
    club_id INT NOT NULL,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES alumno(id) ON DELETE CASCADE,
    FOREIGN KEY (club_id) REFERENCES club(id) ON DELETE CASCADE
);

CREATE TABLE asistencia_club (
    id INT PRIMARY KEY AUTO_INCREMENT,
    alumno_id INT NOT NULL, -- Nos vincula directamente con su única inscripción al club
    fecha DATE NOT NULL,
    estado ENUM('presente', 'ausente', 'retardo', 'justificado') NOT NULL DEFAULT 'presente',
    FOREIGN KEY (alumno_id) REFERENCES inscripcion_club(alumno_id) ON DELETE CASCADE,
    UNIQUE (alumno_id, fecha) -- Evita pasar lista dos veces al mismo alumno en la misma fecha
);

-- Sentencia insert para crear un usuario admin por defecto
INSERT INTO user (nombre, email, pwd, rol, fecha_nacimiento) VALUES ('Admin', 'admin@altamira.com', 'admin', 'admin', '2008-11-26');