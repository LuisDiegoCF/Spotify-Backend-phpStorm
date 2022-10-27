<?php

use App\controllers\AlbumController;
use App\controllers\ArtistaController;
use App\controllers\CancionController;
use App\controllers\GeneroController;

$controller = "genero";
$action = "list";
if (isset($_GET["controller"])) {
    $controller = $_GET["controller"];
}
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
//echo "Controller: $controller <br>";
//echo "Action: $action <br>";

switch ($controller) {
    case "genero":
        switch ($action) {
            case "list":
                // aqui voy a validar que la api solo acepte lo que uno necesite
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    // 405 significa que el metodo no esta permitido
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                GeneroController::index();
                break;
            case "store":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                // obtengo todo el texto que hay adentro de lo que estoy enviando
                $body = file_get_contents("php://input");
                GeneroController::store($body);
                break;
            case "update":
                if ($_SERVER["REQUEST_METHOD"] == "PUT") {
                    $body = file_get_contents("php://input");
                    GeneroController::updatePut($_REQUEST["id"], $body);
                    return;
                }
                if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                    $body = file_get_contents("php://input");
                    GeneroController::updatePatch($_REQUEST["id"], $body);
                    return;
                }
                http_response_code(405);
                die("Error 405: Method Not Allowed");
            case "delete":
                if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                GeneroController::delete($_GET["id"]);
                break;
            case "detail":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                GeneroController::detail($_GET["id"]);
                break;
            case "photo":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                GeneroController::photo($_GET["id"], $_FILES);
                break;
        }
        break;
    case "artista":
        switch ($action) {
            case "list":
                // aqui voy a validar que la api solo acepte lo que uno necesite
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    // 405 significa que el metodo no esta permitido
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                ArtistaController::index();
                break;
            case "store":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                // obtengo todo el texto que hay adentro de lo que estoy enviando
                $body = file_get_contents("php://input");
                ArtistaController::store($body);
                break;
            case "update":
                if ($_SERVER["REQUEST_METHOD"] == "PUT") {
                    $body = file_get_contents("php://input");
                    ArtistaController::updatePut($_REQUEST["id"], $body);
                    return;
                }
                if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                    $body = file_get_contents("php://input");
                    ArtistaController::updatePatch($_REQUEST["id"], $body);
                    return;
                }
                http_response_code(405);
                die("Error 405: Method Not Allowed");
            case "delete":
                if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                ArtistaController::delete($_GET["id"]);
                break;
            case "detail":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                ArtistaController::detail($_GET["id"]);
                break;
            case "photo":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                ArtistaController::photo($_GET["id"], $_FILES);
                break;
            case "listByGenero":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                ArtistaController::listByGenero($_GET["id"]);
                break;
            case "listByAlbum":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                ArtistaController::listByAlbum($_GET["id"]);
                break;
        }
        break;
    case "album":
        switch ($action) {
            case "list":
                // aqui voy a validar que la api solo acepte lo que uno necesite
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    // 405 significa que el metodo no esta permitido
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                AlbumController::index();
                break;
            case "store":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                // obtengo todo el texto que hay adentro de lo que estoy enviando
                $body = file_get_contents("php://input");
                AlbumController::store($body);
                break;
            case "update":
                if ($_SERVER["REQUEST_METHOD"] == "PUT") {
                    $body = file_get_contents("php://input");
                    AlbumController::updatePut($_REQUEST["id"], $body);
                    return;
                }
                if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                    $body = file_get_contents("php://input");
                    AlbumController::updatePatch($_REQUEST["id"], $body);
                    return;
                }
                http_response_code(405);
                die("Error 405: Method Not Allowed");
            case "delete":
                if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                AlbumController::delete($_GET["id"]);
                break;
            case "detail":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                AlbumController::detail($_GET["id"]);
                break;
            case "photo":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                AlbumController::photo($_GET["id"], $_FILES);
                break;
            case "listByArtista":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                AlbumController::listByArtista($_GET["id"]);
                break;
        }
        break;
    case "cancion":
        switch ($action) {
            case "list":
                // aqui voy a validar que la api solo acepte lo que uno necesite
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    // 405 significa que el metodo no esta permitido
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                CancionController::index();
                break;
            case "store":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                // obtengo todo el texto que hay adentro de lo que estoy enviando
                $body = file_get_contents("php://input");
                CancionController::store($body);
                break;
            case "update":
                if ($_SERVER["REQUEST_METHOD"] == "PUT") {
                    $body = file_get_contents("php://input");
                    CancionController::updatePut($_REQUEST["id"], $body);
                    return;
                }
                if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
                    $body = file_get_contents("php://input");
                    CancionController::updatePatch($_REQUEST["id"], $body);
                    return;
                }
                http_response_code(405);
                die("Error 405: Method Not Allowed");
            case "delete":
                if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                CancionController::delete($_GET["id"]);
                break;
            case "detail":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                CancionController::detail($_GET["id"]);
                break;
            case "photo":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                CancionController::photo($_GET["id"], $_FILES);
                break;
            case "audio":
                if ($_SERVER["REQUEST_METHOD"] != "POST") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                CancionController::audio($_GET["id"], $_FILES);
                break;
            case "listByAlbum":
                if ($_SERVER["REQUEST_METHOD"] != "GET") {
                    http_response_code(405);
                    die("Error 405: Method Not Allowed");
                }
                CancionController::listByAlbum($_GET["id"]);
                break;
        }
        break;
}