<?php

namespace App\controllers;

use App\models\bll\ArtistaBLL;
use App\utils\ValidationUtils;

class ArtistaController {
    static function index() {
        $listaArtistas = ArtistaBLL::selectAll();
        echo json_encode($listaArtistas);
    }

    static function store($body) {
        $request = json_decode($body);
        if ($request == null) {
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        if (!ValidationUtils::validarRequest($request, "nombre")) {
            return;
        }
        $nombre = $request->nombre;
        if (!ValidationUtils::validarRequest($request, "idGenero")) {
            return;
        }
        $idGenero = $request->idGenero;
        $id = ArtistaBLL::insert($nombre, $idGenero);
        $objArtista = ArtistaBLL::selectById($id);
        echo json_encode($objArtista);
    }

    static function updatePut($id, $body) {
        $objArtista = ArtistaBLL::selectById($id);
        if ($objArtista == null) {
            http_response_code(404);
            die("Error 404: Not Found");
        }
        $request = json_decode($body);
        if ($request == null) {
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        if (!ValidationUtils::validarRequest($request, "nombre")) {
            return;
        }
        $nombre = $request->nombre;
        if (!ValidationUtils::validarRequest($request, "idGenero")) {
            return;
        }
        $idGenero = $request->idGenero;
        ArtistaBLL::update($nombre, $idGenero, $id);
        $objArtista = ArtistaBLL::selectById($id);
        echo json_encode($objArtista);
    }

    static function updatePatch($id, $body) {
        $objArtista = ArtistaBLL::selectById($id);
        if ($objArtista == null) {
            http_response_code(404);
            die("Error 404: Not Found");
        }
        $request = json_decode($body);
        if ($request == null) {
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        if (property_exists($request, "nombre")) {
            $objArtista->nombre = $request->nombre;
        }
        if (property_exists($request, "idGenero")) {
            $objArtista->idGenero = $request->idGenero;
        }
        ArtistaBLL::update(
            $objArtista->nombre,
            $objArtista->idGenero,
            $id);
        $objArtista = ArtistaBLL::selectById($id);
        echo json_encode($objArtista);
    }

    static function delete($id) {
        $objArtista = ArtistaBLL::selectById($id);
        if ($objArtista == null) {
            http_response_code(404);
            die("Error 404: Not Found");
        }
        ArtistaBLL::delete($id);
        echo json_encode(["res" => "ok"]);
    }

    static function detail($id) {
        $objArtista = ArtistaBLL::selectById($id);
        if ($objArtista == null) {
            http_response_code(404);
            die("Error 404: Not Found");
        }
        echo json_encode($objArtista);
    }

    static function photo($id, array $files){

        $objArtista = ArtistaBLL::selectById($id);
        if ($objArtista == null) {
            http_response_code(404);
            die("Error 404: Not Found");
        }
        //print_r($files);
        $file = $files["imagen"];
        $tmp = $file["tmp_name"];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newName = $id . "." . $ext;
        $newPath = "perfil/" . $newName;
        move_uploaded_file($tmp, $newPath);
        echo json_encode(["res" => "ok"]);
    }

    static function listByGenero($idAlbum){
        $listaArtistas = ArtistaBLL::selectAllByGenero($idAlbum);
        echo json_encode($listaArtistas);
    }

    static function listByAlbum($id){
        $listaArtistas = ArtistaBLL::selectAllByAlbum($id);
        echo json_encode($listaArtistas);
    }
}