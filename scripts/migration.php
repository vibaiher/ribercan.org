<?php

/**
*
* SHOW COLUMNS FROM pro_perros
*
* +----------------------+--------------+------+-----+---------+----------------+
* | Field                | Type         | Null | Key | Default | Extra          |
* +----------------------+--------------+------+-----+---------+----------------+
* | perro_id             | int(11)      | NO   | PRI | NULL    | auto_increment |
* | perro_referencia     | varchar(20)  | NO   |     |         |                |
* | perro_nombre         | varchar(30)  | NO   |     |         |                |
* | perro_edad           | varchar(100) | NO   |     |         |                |
* | perro_sexo           | int(1)       | NO   |     | 0       |                |
* | perro_tamano         | char(1)      | NO   |     |         |                |
* | perro_caracter       | blob         | YES  |     | NULL    |                |
* | perro_historia       | blob         | YES  |     | NULL    |                |
* | perro_consejos       | blob         | YES  |     | NULL    |                |
* | perro_apadrinado     | varchar(200) | YES  |     | NULL    |                |
* | perro_adoptado       | varchar(200) | YES  |     | NULL    |                |
* | perro_estado         | int(1)       | NO   |     | 0       |                |
* | perro_altura         | varchar(100) | NO   |     | NULL    |                |
* | perro_entrada        | varchar(50)  | YES  |     | NULL    |                |
* | perro_esterilizacion | varchar(200) | YES  |     | NULL    |                |
* | perro_peso           | varchar(50)  | YES  |     | NULL    |                |
* +----------------------+--------------+------+-----+---------+----------------+
*
* perro_estado = 0 -> No disponible
* perro_estado = 1 -> Disponible
* perro_estado = 2 -> Apadrinado
* perro_estado = 3 -> Adoptado
* perro_estado = 4 -> Buscan Padrino
* perro_estado = 5 -> Urgente
* perro_estado = 6 -> Perdido
* perro_estado = 7 -> Fallecido
*
* SHOW COLUMNS FROM dogs
*
* +-------------+--------------+------+-----+---------+----------------+
* | Field       | Type         | Null | Key | Default | Extra          |
* +-------------+--------------+------+-----+---------+----------------+
* | id          | int(11)      | NO   | PRI | NULL    | auto_increment |
* | name        | varchar(255) | NO   |     | NULL    |                |
* | sex         | tinyint(1)   | NO   |     | 0       |                |
* | birthday    | datetime     | NO   |     | NULL    |                |
* | join_date   | datetime     | NO   |     | NULL    |                |
* | sterilized  | tinyint(1)   | NO   |     | NULL    |                |
* | godfather   | varchar(255) | YES  |     | NULL    |                |
* | description | longtext     | YES  |     | NULL    |                |
* | size        | varchar(255) | NO   |     | NULL    |                |
* | urgent      | tinyint(1)   | NO   |     | 0       |                |
* | video       | varchar(255) | YES  |     | NULL    |                |
* | health      | longtext     | YES  |     | NULL    |                |
* +-------------+--------------+------+-----+---------+----------------+
*
* const MALE = "0";
* const FEMALE = "1";
*
* const SMALL = "0";
* const MEDIUM = "1";
* const BIG = "2";
*
* const PUPPY = "0";
* const ADULT = "1";
*
* const NOT_STERILIZED_YET = "0";
* const STERILIZED = "1";
*
* SHOW COLUMNS FROM odec_noticias;
*
* +----------------------+--------------+------+-----+---------+----------------+
* | Field                | Type         | Null | Key | Default | Extra          |
* +----------------------+--------------+------+-----+---------+----------------+
* | noticia_id           | int(11)      | NO   | PRI | NULL    | auto_increment |
* | noticia_titulo       | varchar(200) | NO   |     |         |                |
* | noticia_breve        | text         | YES  |     | NULL    |                |
* | noticia_contenido    | text         | YES  |     | NULL    |                |
* | noticia_fecha_inicio | date         | YES  |     | NULL    |                |
* | noticia_fecha_fin    | date         | YES  |     | NULL    |                |
* | noticia_idioma_lang  | char(3)      | YES  |     | NULL    |                |
* +----------------------+--------------+------+-----+---------+----------------+
*
* SHOW COLUMNS FROM news;
*
* +--------------+--------------+------+-----+---------+----------------+
* | Field        | Type         | Null | Key | Default | Extra          |
* +--------------+--------------+------+-----+---------+----------------+
* | id           | int(11)      | NO   | PRI | NULL    | auto_increment |
* | title        | varchar(255) | NO   |     | NULL    |                |
* | body         | longtext     | NO   |     | NULL    |                |
* | summary      | longtext     | NO   |     | NULL    |                |
* | published_at | datetime     | NO   |     | NULL    |                |
* +--------------+--------------+------+-----+---------+----------------+
*/
$username = 'root';
$password = null;
$old_database = 'jordigiron_ribercan';
$database = 'ribercan_dev';
$host = 'localhost';

$old_connection = new PDO("mysql:dbname=$old_database;host=$host", $username, $password);
$connection = new PDO("mysql:dbname=$database;host=$host", $username, $password);

/**
 * More dogs please!
 */
$dogs = $old_connection->query(
    'SELECT * FROM pro_perros'
);
$insert_dog = $connection->prepare(
    'INSERT INTO dogs (name, sex, birthday, join_date, sterilized, godfather, description, size, urgent) VALUES(:name, :sex, :birthday, :join_date, :sterilized, :godfather, :description, :size, :urgent)'
);

$connection->exec('DELETE FROM dog_images');
$connection->exec('DELETE FROM dogs');

foreach ($dogs as $dog) {
    $insert_dog->execute(
        array(
            ':name' => utf8_decode(format_name_from($dog['perro_nombre'])),
            ':sex' => format_sex_from($dog['perro_sexo']),
            ':birthday' => format_datetime_from($dog['perro_edad']),
            ':join_date' => format_datetime_from($dog['perro_entrada']),
            ':sterilized' => utf8_decode(format_sterilized_from($dog['perro_esterilizacion'])),
            ':godfather' => utf8_decode($dog['perro_apadrinado']),
            ':description' => utf8_decode($dog['perro_caracter']),
            ':size' => format_size_from($dog['perro_tamano']),
            ':urgent' => format_urgent_from($dog['perro_estado'])
        )
    );
    echo "Inserted dog: {$dog['perro_nombre']}\n";
}

/**
 * Now news, come on!
 */

$news = $old_connection->query(
    'SELECT * FROM odec_noticias'
);
$insert_announcement = $connection->prepare(
    'INSERT INTO news (title, summary, body, published_at) VALUES(:title, :summary, :body, :published_at)'
);

$connection->exec('DELETE FROM announcement_images');
$connection->exec('DELETE FROM news');

foreach ($news as $announcement) {
    $result = $insert_announcement->execute(
        array(
            ':title' => utf8_decode($announcement['noticia_titulo']),
            ':summary' => utf8_decode($announcement['noticia_breve']),
            ':body' => utf8_decode($announcement['noticia_contenido']),
            ':published_at' => "{$announcement['noticia_fecha_inicio']} 00:00:00"
        )
    );
    echo "Inserted announcement: {$announcement['noticia_titulo']}\n";
}

function format_name_from($string) {
  return ucfirst(strtolower($string));
}

function format_sex_from($number) {
  if ($number == 2) return 0; // MALE

  return 1; // FEMALE
}

function format_datetime_from($string) {
  $datetime = DateTime::createFromFormat('d/m/Y', $string);
  if (!$datetime) return null;

  return $datetime->format('Y-m-d 00:00:00');
}

function format_sterilized_from($string) {
  if (empty($string)) return 0; // NOT_STERILIZED_YET

  return 1; // STERILIZED
}

function format_size_from($letter) {
  switch ($letter) {
    case 'P':
    case 'C':
      return 0; // SMALL

    case 'M':
      return 1; // MEDIUM

    case 'G':
    case 'X':
      return 2; // BIG
  }
  return null;
}

function format_urgent_from($number) {
  if ($number != 5) return 0; // URGENT

  return 1; // URGENT
}
