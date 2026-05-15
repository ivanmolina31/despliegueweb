CREATE DATABASE IF NOT EXISTS legado_digital
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Crear usuario para la web y darle permisos
CREATE USER IF NOT EXISTS 'ivanmc'@'%' IDENTIFIED BY 'Admin123!';
GRANT ALL PRIVILEGES ON legado_digital.* TO 'ivanmc'@'%';
FLUSH PRIVILEGES;

USE legado_digital;

CREATE TABLE IF NOT EXISTS articulos (
  id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo    VARCHAR(300) NOT NULL UNIQUE,
  autor     VARCHAR(200),
  fecha_pub DATE,
  texto     TEXT,
  ruta_pdf  VARCHAR(500),
  PRIMARY KEY (id)
);

ALTER TABLE articulos ADD COLUMN IF NOT EXISTS texto TEXT;
ALTER TABLE articulos ADD COLUMN IF NOT EXISTS ruta_pdf VARCHAR(500);

INSERT IGNORE INTO articulos (titulo, autor, fecha_pub, texto, ruta_pdf)
VALUES
  (
    'Mapa antiguo de la provincia de Navarra',
    'Cartografía Histórica',
    '1850-01-01',
    'Representación cartográfica del territorio navarro en el siglo XIX, mostrando límites administrativos, principales núcleos de población y características geográficas de la provincia. Este documento es esencial para comprender la organización territorial de la época.',
    'pdfs/mapa.pdf'
  ),

  (
    'Mapa antiguo de Quirós',
    'Archivo Municipal de Quirós',
    '1776-06-15',
    'Carta geográfica de la localidad de Quirós que detalla su distribución urbana, caminos principales e hitos singulares. Constituye un registro invaluable de la estructura municipal a finales del siglo XIX y principios del XX.',
    'pdfs/mapa-quiros.pdf'
  ),

  (
    'Partitura de Marie Stuart por J. Leybach',
    'Joseph Leybach',
    '1883-03-22',
    'Composición musical de Joseph Leybach dedicada a la figura histórica de María Estuardo. Esta partitura representa un importante testimonio de la producción artística romántica del siglo XIX en relación con la historia europea.',
    'pdfs/partitura.pdf'
  ),

  (
    'Los Platos Rotos - Francisco Soler',
    'Francisco Soler',
    '1838-09-10',
    'Partitura de la composición "Los Platos Rotos" del compositor Francisco Soler. Este documento refleja la tradición musical española del primer tercio del siglo XX y constituye un testimonio de la creatividad compositiva de la época.',
    'pdfs/partitura-soler.pdf'
  ),

  (
    'Certificación de la partida de bautismo de Carolina Coronado',
    'Archivo Parroquial',
    '1896-01-12',
    'Documento oficial que certifica el bautismo de Carolina Coronado, destacada escritora española del siglo XIX. Este registro parroquial es un documento primario de vital importancia para la genealogía y la historia personal de una de las figuras literarias más relevantes de la época.',
    'pdfs/partida.pdf'
  );