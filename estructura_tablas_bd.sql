USE Configurador_Presupuestos;

CREATE TABLE IF NOT EXISTS servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen_ruta VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    interes TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cliente_servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    servicio_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);

INSERT INTO servicios (nombre,tipo, precio, imagen_ruta) VALUES 
('SEO Web','Digitalización', 800.00, 'imagenes/seo.webp'),
('Redes sociales','Digitalización', 650.00, 'imagenes/rrss.webp'),
('Diseño para empresas','Branding', 500.00, 'imagenes/logos.webp'),
('Naming para empresas','Branding', 350.00, 'imagenes/naming.webp'),
('Branding para empresas','Branding', 900.00, 'imagenes/branding.webp'),
('Desarrollo página web','Digitalización', 750.00, 'imagenes/web.webp');