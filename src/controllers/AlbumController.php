<?php

namespace App\controllers;

use App\models\bll\AlbumBLL;
use App\utils\ValidationUtils;

class AlbumController {
    static function index() {
        $listaAlbumes = AlbumBLL::selectAll();
        echo json_encode($listaAlbumes);
    }

    static function store ($body){
        $request = json_decode($body);
        if($request == null){
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        if(!ValidationUtils::validarRequest($request, "nombre")){
            return;
        }
        $nombre = $request->nombre;
        if(!ValidationUtils::validarRequest($request, "idArtista")){
            return;
        }
        $idArtista = $request->idArtista;
        $id = AlbumBLL::insert($nombre, $idArtista);
        $objAlbum = AlbumBLL::selectById($id);
        echo json_encode($objAlbum);
    }

    static function updatePut($id, $body){
        $objAlbum = AlbumBLL::selectById($id);
        if($objAlbum == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        $request = json_decode($body);
        if($request == null){
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        if(!ValidationUtils::validarRequest($request, "nombre")){
            return;
        }
        $nombre = $request->nombre;
        if(!ValidationUtils::validarRequest($request, "idArtista")){
            return;
        }
        $idArtista = $request->idArtista;
        AlbumBLL::update($nombre, $idArtista, $id);
        $objAlbum = AlbumBLL::selectById($id);
        echo json_encode($objAlbum);
    }

    static function updatePatch($id, $body){
        $objAlbum = AlbumBLL::selectById($id);
        if($objAlbum == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        $request = json_decode($body);
        if($request == null){
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        if(property_exists($request, "nombre")){
            $objAlbum->nombre = $request->nombre;
        }
        if(property_exists($request, "idArtista")){
            $objAlbum->idArtista = $request->idArtista;
        }
        AlbumBLL::update(
            $objAlbum->nombre,
            $objAlbum->idArtista,
            $id
        );
        $objAlbum = AlbumBLL::selectById($id);
        echo json_encode($objAlbum);
    }

    static function delete($id){
        $objAlbum = AlbumBLL::selectById($id);
        if($objAlbum == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        AlbumBLL::delete($id);
        echo json_encode(["res" => "ok"]);
    }

    static function detail($id){
        $objAlbum = AlbumBLL::selectById($id);
        if($objAlbum == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        echo json_encode($objAlbum);
    }

    static function photo($id, array $files){
        $objAlbum = AlbumBLL::selectById($id);
        if($objAlbum == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        //print_r($files);
        $file = $files["imagen"];
        $tmp = $file["tmp_name"];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newName = $id . "." . $ext;
        $newPath = "album/" . $newName;
        move_uploaded_file($tmp, $newPath);
        echo json_encode(["res" => "ok"]);

    }

    public static function listByArtista($id){
        $listaAlbumes = AlbumBLL::selectAllByArtista($id);
        echo json_encode($listaAlbumes);
    }
}