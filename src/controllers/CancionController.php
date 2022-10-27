<?php

namespace App\controllers;

use App\models\bll\CancionBLL;
use App\utils\ValidationUtils;

class CancionController {
    static function index(){
        $listaCanciones = CancionBLL::selectAll();
        echo json_encode($listaCanciones);
    }

    static function store($body){
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
        if(!ValidationUtils::validarRequest($request, "idAlbum")){
            return;
        }
        $idAlbum = $request->idAlbum;
        $id = CancionBLL::insert($nombre, $idAlbum);
        $objCancion = CancionBLL::selectById($id);
        echo json_encode($objCancion);
    }

    static function updatePut($id, $body){
        $objCancion = CancionBLL::selectById($id);
        if($objCancion == null){
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
        if(!ValidationUtils::validarRequest($request, "idAlbum")){
            return;
        }
        $idAlbum = $request->idAlbum;
        CancionBLL::update($nombre, $idAlbum, $id);
        $objCancion = CancionBLL::selectById($id);
        echo json_encode($objCancion);
    }

    static function updatePatch($id, $body){
        $objCancion = CancionBLL::selectById($id);
        if($objCancion == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        $request = json_decode($body);
        if($request == null){
            http_response_code(400);
            echo "request mal formado";
            return;
        }
        // hay que validar que los parametros que los parametros que se estan enviando sean los correctos
        if(property_exists($request, "nombre")){
            $objCancion->nombre = $request->nombre;
        }
        if(property_exists($request, "idAlbum")){
            $objCancion->idAlbum = $request->idAlbum;
        }
        CancionBLL::update(
            $objCancion->nombre,
            $objCancion->idAlbum,
            $id
        );
        $objCancion = CancionBLL::selectById($id);
        echo json_encode($objCancion);
    }

    static function delete($id){
        $objCancion = CancionBLL::selectById($id);
        if($objCancion == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        CancionBLL::delete($id);
        echo json_encode(["res" => "ok"]);
    }

    static function detail($id){
        $objCancion = CancionBLL::selectById($id);
        if($objCancion == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        $objCancion = CancionBLL::selectById($id);
        echo json_encode($objCancion);
    }

    static function photo($id, array $files){
        $objCancion = CancionBLL::selectById($id);
        if($objCancion == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        //print_r($files);
        $file = $files["imagen"];
        $tmp = $file["tmp_name"];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newName = $id . "." . $ext;
        $newPath = "img/" . $newName;
        move_uploaded_file($tmp, $newPath);
        echo json_encode(["res" => "ok"]);
    }

    public static function audio($id, array $files)
    {
        $objCancion = CancionBLL::selectById($id);
        if($objCancion == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        //print_r($files);
        $file = $files["audio"];
        $tmp = $file["tmp_name"];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newName = $id . "." . $ext;
        $newPath = "audio/" . $newName;
        move_uploaded_file($tmp, $newPath);
        echo json_encode(["res" => "ok"]);
    }

    public static function listByAlbum($id)
    {
        $listaCanciones = CancionBLL::selectAllByAlbum($id);
        echo json_encode($listaCanciones);
    }
}