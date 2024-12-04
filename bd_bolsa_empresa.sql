-- Creación de la base de datos
CREATE DATABASE BolsaDeTrabajo;
USE BolsaDeTrabajo;

-- Tabla de Usuarios (Empresas, Candidatos y Administradores)
CREATE TABLE Usuarios (
    usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    contrasena VARCHAR(100),
    tipo_usuario ENUM('empresa', 'candidato', 'administrador'),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Empresas
CREATE TABLE Empresas (
    empresa_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT UNIQUE,
    nombre_empresa VARCHAR(100),
    descripcion TEXT,
    ubicacion VARCHAR(100),
    sitio_web VARCHAR(100),
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla de Candidatos
CREATE TABLE Candidatos (
    candidato_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT UNIQUE,
    nombre_completo VARCHAR(100),
    fecha_nacimiento DATE,
    genero ENUM('M', 'F', 'Otro'),
    ubicacion VARCHAR(100),
    telefono VARCHAR(15),
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla de Perfiles (para la gestión del perfil del candidato)
CREATE TABLE Perfiles (
    perfil_id INT PRIMARY KEY AUTO_INCREMENT,
    candidato_id INT UNIQUE,
    descripcion TEXT,
    experiencia TEXT,
    habilidades TEXT,
    educacion TEXT,
    idiomas TEXT,
    FOREIGN KEY (candidato_id) REFERENCES Candidatos(candidato_id) ON DELETE CASCADE
);

-- Tabla de Experiencias Laborales
CREATE TABLE ExperienciasLaborales (
    experiencia_id INT PRIMARY KEY AUTO_INCREMENT,
    perfil_id INT,
    empresa VARCHAR(100),
    cargo VARCHAR(100),
    fecha_inicio DATE,
    fecha_fin DATE,
    descripcion TEXT,
    FOREIGN KEY (perfil_id) REFERENCES Perfiles(perfil_id) ON DELETE CASCADE
);

-- Tabla de Ofertas de Trabajo
CREATE TABLE Ofertas (
    oferta_id INT PRIMARY KEY AUTO_INCREMENT,
    empresa_id INT,
    titulo VARCHAR(100),
    descripcion TEXT,
    requisitos TEXT,
    ubicacion VARCHAR(100),
    salario DECIMAL(10, 2),
    estado ENUM('activa', 'cerrada') DEFAULT 'activa',
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES Empresas(empresa_id) ON DELETE CASCADE
);

-- Tabla de Categorías de Empleo
CREATE TABLE Categorias (
    categoria_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_categoria VARCHAR(100)
);

-- Tabla de relación entre Ofertas y Categorías
CREATE TABLE OfertaCategoria (
    oferta_id INT,
    categoria_id INT,
    FOREIGN KEY (oferta_id) REFERENCES Ofertas(oferta_id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(categoria_id) ON DELETE CASCADE
);

-- Tabla de Postulaciones
CREATE TABLE Postulaciones (
    postulacion_id INT PRIMARY KEY AUTO_INCREMENT,
    oferta_id INT,
    candidato_id INT,
    fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aceptada', 'rechazada', 'en proceso'),
    FOREIGN KEY (oferta_id) REFERENCES Ofertas(oferta_id) ON DELETE CASCADE,
    FOREIGN KEY (candidato_id) REFERENCES Candidatos(candidato_id) ON DELETE CASCADE
);

-- Tabla de Conversaciones entre Usuarios
CREATE TABLE UsuariosConversaciones (
    conversacion_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario1_id INT,
    usuario2_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario1_id) REFERENCES Usuarios(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (usuario2_id) REFERENCES Usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla de Mensajes
CREATE TABLE Mensajes (
    mensaje_id INT PRIMARY KEY AUTO_INCREMENT,
    conversacion_id INT,
    remitente_id INT,
    contenido TEXT,
    leido BOOLEAN DEFAULT FALSE,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversacion_id) REFERENCES UsuariosConversaciones(conversacion_id) ON DELETE CASCADE
);

-- Tabla de Administradores
CREATE TABLE Administradores (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT UNIQUE,
    rol VARCHAR(50),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id) ON DELETE CASCADE
);

-- Tabla de Notificaciones
CREATE TABLE Notificaciones (
    notificacion_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    mensaje TEXT,
    tipo_notificacion ENUM('vacante', 'postulacion', 'mensaje', 'sistema'),
    leido BOOLEAN DEFAULT FALSE,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id) ON DELETE CASCADE
);

-- Índices para mejorar el rendimiento
CREATE INDEX idx_usuario_id ON Usuarios(usuario_id);
CREATE INDEX idx_empresa_id ON Empresas(empresa_id);
CREATE INDEX idx_candidato_id ON Candidatos(candidato_id);
CREATE INDEX idx_oferta_id ON Ofertas(oferta_id);
