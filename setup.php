<?php
require_once __DIR__ . '/comun.php';
require_once __DIR__ . '/conf/conf.php';

use Jaxon\Jaxon;
use function Jaxon\jaxon;
use Jaxon\Response\Response;
use GuzzleHttp\Client;

$jaxon = jaxon();
$jaxon->setOption("js.lib.uri", BASE_URL . "jaxon-dist");
$jaxon->setOption('core.request.uri', BASE_URL . 'backend.php');

function logMessage(Response $r, mixed $dato)
{
    $r->append('log', 'innerHTML', '<div>' . print_r($dato, true) . '</div>');
}

function funcion1($fechaYhora)
{
    $response = jaxon()->newResponse();
    logMessage($response,"La fecha y la hora es: $fechaYhora");
    return $response;
}

function funcion2($nombre)
{
    $response = jaxon()->newResponse();
    logMessage($response,"El nombre del autor o autora es $nombre");
    return $response;
}

function listarLibrosAutor ($isbn)
{
    $response = jaxon()->newResponse();
    $response->clear('otros_libros_autor');

    try {
        $c = new PDO(DB_DSN, DB_USER, DB_PASSWD);
        $stmt = $c->prepare("SELECT autor FROM libros WHERE isbn = :isbn");
        $stmt->execute(['isbn' => $isbn]);
        $autor = $stmt->fetchColumn();

        if (!$autor) {
            logMessage($response, "No se encontró ningún libro con ISBN: $isbn.");
            return $response;
        }
    
        $clienteHTTP=new Client();
        $query = urlencode($autor);
        $url = "https://openlibrary.org/search.json?author=$query";

        $respuesta=$clienteHTTP->request('GET',$url, ['verify'=>false]); //No es necesaria la autenticación
        $body=$respuesta->getBody();
        $data = json_decode($body, true); // true para obtener array asociativo

        if (empty($data['docs'])) {
            logMessage($response, "No se encontraron libros del autor en Open Library.");
            return $response;
        }

        $html = "";

        foreach ($data['docs'] as $libro) {
            $titulo = $libro['title'];
            $autorNombre  = $libro['author_name'][0]; // Obtenemos el primero elemento del array que, en este caso, es el nombre del autor.
            $html .= "$titulo | $autorNombre</br>";
        }

        $response->assign('otros_libros_autor', 'innerHTML', $html);
        $response->assign('otros_libros_autor', 'style.display', 'block');
        $response->assign('otros_libros_autor', 'style.border', '2px dotted blue');
        $response->assign('otros_libros_autor', 'style.padding', '10px');

    } catch (Exception $e) {
        logMessage($response, "Error al consultar libros del autor: " . $e->getMessage());
    }
    return $response;
}

function listarLibrosMMM() {
    $response = jaxon()->newResponse();

    try {
        $pdo = new PDO (DB_DSN, DB_USER, DB_PASSWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $SQL = "SELECT isbn, titulo, autor, anio_publicacion, paginas, ejemplares_disponibles, fecha_creacion, fecha_actualizacion FROM libros";
        $libros = $pdo->query($SQL)->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $response->assign('listaLibros', 'innerHTML', '<p>Error al conectar con la base de datos.</p>');
        logMessage($response, $e->getMessage());
        return $response;
    }

    if (count($libros) === 0) {
        $response->assign('listaLibros', 'innerHTML', '<p>No hay libros registrados.</p>');
        return $response;
    }

     $tabla = '<table>';
    $tabla .= '<thead><tr>
        <th>ISBN</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Año</th>
        <th>Páginas</th>
        <th>Ejemplares</th>
        <th>Fecha de creación</th>
        <th>Fecha de actualización</th>
    </tr></thead><tbody>';

    foreach ($libros as $libro) {
        $tabla .= '<tr>' .
            '<td>' . htmlspecialchars($libro['isbn']) . '</td>' .
            '<td>' . htmlspecialchars($libro['titulo']) . '</td>' .
            '<td>' . htmlspecialchars($libro['autor']) . '</td>' .
            '<td>' . htmlspecialchars($libro['anio_publicacion']) . '</td>' .
            '<td>' . htmlspecialchars($libro['paginas']) . '</td>' .
            '<td>' . htmlspecialchars($libro['ejemplares_disponibles']) . '</td>' .
            '<td>' . htmlspecialchars($libro['fecha_creacion']) . '</td>' .
            '<td>' . htmlspecialchars($libro['fecha_actualizacion']) . '</td>' .
        '</tr>';
    }

    $tabla .= '</tbody></table>';
    $response->assign('listaLibros', 'innerHTML', $tabla);
    return $response;
}

function registrarLibroMMM($isbn, $titulo, $autor, $anio_publicacion, $paginas, $ejemplares_disponibles) {
    $response = jaxon()->newResponse();
    $errores = [];

    // Validaciones
    if (empty($titulo)) {
        $errores[] = "El título no puede estar vacío.";
    } else if (strlen($titulo) > 255) {
        $errores[] = "El títilo no puede tener más de 255 caracteres.";
    }

    if (empty($isbn)) {
        $errores[] = "El ISBN no puede estar vacío.";
    } else if (strlen($isbn) > 13 ) {
        $errores[] = "El ISBN no puede tener más de 13 dígitos.";
    } else if (!ctype_digit($isbn)) {

    }

    if (empty($autor)) {
        $errores[] = "El autor no puede estar vacío.";
    } else if (strlen($autor) > 255) {
        $errores[] = "El autor no puede tener más de 255 caracteres.";
    }

    if (!ctype_digit($anio_publicacion) || (int)$anio_publicacion <= 0 || (int)$anio_publicacion >= (int)date("Y")) {
        $errores[] = "El año de publicación debe ser un número entero mayor de 0 y menor del año actual.";
    }

    if (!ctype_digit($paginas) || (int)$paginas <= 0) {
        $errores[] = "El número de páginas debe ser un número entero mayor de 0";
    }

    if(!ctype_digit($ejemplares_disponibles) || (int)$ejemplares_disponibles < 0) {
        $errores[] = "El número de ejemplares disponibles debe ser un número entero mayor o igual que 0";
    }

    if($errores) {
        foreach($errores as $e)
            logMessage($response, $e);
        return $response;
    }

    try {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar ISBN duplicado
        $stmt = $pdo->prepare("SELECT id FROM libros WHERE isbn = ?");
        $stmt->execute([$isbn]);
        if($stmt->fetch()) {
            logMessage($response, "Ya existe un libro con el ISBN $isbn.");
            return $response;
        }

        // Insertar libro
        $stmt = $pdo->prepare("INSERT INTO libros (isbn, titulo, autor, anio_publicacion, paginas, ejemplares_disponibles) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$isbn, $titulo, $autor, $anio_publicacion, $paginas, $ejemplares_disponibles]);
        $idLibro = $pdo->lastInsertId();

        logMessage($response, "Libro registrado con ID $idLibro por María Morillo Maqueda.");

        $response->appendResponse(listarLibrosMMM());
        return $response;

    } catch(Exception $e) {
        logMessage($response, "Error en la inserción: " . $e->getMessage());
        return $response;
    }
}

$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcion1');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcion2');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarLibrosAutor');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarLibrosMMM');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'registrarLibroMMM');

