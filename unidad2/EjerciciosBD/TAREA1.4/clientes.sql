DROP DATABASE IF EXISTS clientes;
CREATE DATABASE IF NOT EXISTS clientes;
USE clientes;

DROP TABLE IF EXISTS infoClientes;
CREATE TABLE infoClientes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45),
    foto BLOB DEFAULT './fotos/silueta.jpg'

);
USE clientes;
INSERT INTO infoClientes(nombre,foto) VALUES ('Aria','./fotos/aria.jpg');
INSERT INTO infoClientes(nombre,foto) VALUES ('Cersei','./fotos/cersei.jpg');
INSERT INTO infoClientes(nombre,foto) VALUES ('Daenerys','./fotos/daenerys.jpg');
INSERT INTO infoClientes(nombre,foto) VALUES ('Jaime','./fotos/jaime.jpg');
INSERT INTO infoClientes(nombre,foto) VALUES ('Jon','./fotos/jon.jpg');
INSERT INTO infoClientes(nombre,foto) VALUES ('Sansa','./fotos/sansa.jpg');
INSERT INTO infoClientes(nombre,foto) VALUES ('Tyrion','./fotos/tyrion.jpg');
INSERT INTO infoClientes(nombre) VALUES ('Hombre sin rostro');

