<?php

namespace App\controllers;

use App\models\bll\GeneroBLL;
use App\utils\ValidationUtils;

class GeneroController {
    static function index(){
        $listaGeneros = GeneroBLL::selectAll();
        echo json_encode($listaGeneros);
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
        $id = GeneroBLL::insert($nombre);
        $objGenero = GeneroBLL::selectById($id);
        echo json_encode($objGenero);
    }

    static function updatePut($id, $body){
        $objGenero = GeneroBLL::selectById($id);
        if($objGenero == null){
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
        GeneroBLL::update($nombre, $id);
        $objGenero = GeneroBLL::selectById($id);
        echo json_encode($objGenero);
    }

    static function updatePatch($id, $body){
        $objGenero = GeneroBLL::selectById($id);
        if($objGenero == null){
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
            $objGenero->nombre = $request->nombre;
        }
        GeneroBLL::update($objGenero->nombre, $id);
        $objGenero = GeneroBLL::selectById($id);
        echo json_encode($objGenero);
    }

    static function delete($id){
        $objGenero = GeneroBLL::selectById($id);
        if($objGenero == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        GeneroBLL::delete($id);
        echo json_encode(["res" => "ok"]);
    }

    static function detail($id){
        $objGenero = GeneroBLL::selectById($id);
        if($objGenero == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        echo json_encode($objGenero);
    }

    static function photo($id, array $files){
        $objGenero = GeneroBLL::selectById($id);
        if($objGenero == null){
            http_response_code(404);
            die("Error 404: Not Found");
        }
        /*if(!ValidationUtils::validarFiles($files, "foto")){
            return;
        }*/
        $file = $files["imagen"];
        $tmp = $file["tmp_name"];
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newName = $id . "." . $ext;
        $newPath = "caratula/" . $newName;
        move_uploaded_file($tmp, $newPath);
        echo json_encode(["res" => "ok"]);
    }
}