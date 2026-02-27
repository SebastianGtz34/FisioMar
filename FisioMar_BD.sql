-- Crear la base de datos
-- Nota: se usa 'fisiomar' para coincidir con conn.php actual.
CREATE DATABASE fisiomar;
USE fisiomar;

-- Tabla de pacientes
CREATE TABLE pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    sexo VARCHAR(20),
    edad INT,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    ocupacion VARCHAR(100),
    estado_civil VARCHAR(50),
    seguro_medico VARCHAR(100),
    diagnostico TEXT,
    antecedentes TEXT,
    folio VARCHAR(100),
    estatus VARCHAR(50),
    fecha_cita DATE,
    hora_cita TIME,
    contacto_emergencia VARCHAR(120),
    telefono_emergencia VARCHAR(20),
    usuario_registro VARCHAR(50),
    archivo_origen VARCHAR(120),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de citas
CREATE TABLE citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo VARCHAR(200),
    estado ENUM('Programada','Realizada','Cancelada') DEFAULT 'Programada',
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente)
);

-- Tabla de sesiones (detalle de cada cita realizada)
CREATE TABLE sesiones (
    id_sesion INT AUTO_INCREMENT PRIMARY KEY,
    id_cita INT NOT NULL,
    tipo_tratamiento VARCHAR(100),
    notas TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cita) REFERENCES citas(id_cita)
);

-- Tabla de reportes
CREATE TABLE reportes (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    tipo ENUM('Historial Completo','Sesiones Realizadas','Resumen de Tratamientos'),
    fecha_generado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente)
);

-- Tabla de usuarios (para login y roles)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol ENUM('Admin','Terapeuta','Recepcionista') DEFAULT 'Terapeuta'
);
