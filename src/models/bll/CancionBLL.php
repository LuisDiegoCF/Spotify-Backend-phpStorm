<?php

namespace App\models\bll;

use App\models\dal\Connection;
use App\models\dto\Cancion;
use PDO;
use PDOException;

class CancionBLL {
    public static function insert($nombre, $idAlbum): int
    {
        try {
            $conn = new Connection();
            // $sql = "INSERT INTO canciones (nombre, album_id) VALUES (:varNombre, :varIdAlbum)";
            $sql= "call sp_Canciones_insert(:varNombre, :varIdAlbum)";
            $result = $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varIdAlbum" => $idAlbum
            ));
            $row = $result->fetch(PDO::FETCH_ASSOC);
            //return $conn->getLastInsertedId();
            return $row['lastId'];
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return 0;
    }

    public static function update($nombre, $idAlbum, $id)
    {
        try {
            $conn = new Connection();
            //$sql = "UPDATE canciones SET nombre = :varNombre, album_id = :varIdAlbum WHERE id = :varId";
            $sql = "call sp_Canciones_update(:varNombre, :varIdAlbum, :varId)";
            $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varIdAlbum" => $idAlbum,
                ":varId" => $id
            ));
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public static function delete($id)
    {
        try {
            $conn = new Connection();
            //$sql = "DELETE FROM canciones WHERE id = :varId";
            $sql = "call sp_Canciones_delete(:varId)";
            $conn->queryWithParams($sql, array(
                ":varId" => $id
            ));
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public static function selectAll(): array
    {
        try {
            $lista = [];
            $conn = new Connection();
            /*$sql = "SELECT c.id, c.nombre, c.album_id, a.id as id_album, a.nombre as nombre_album
                    FROM canciones c 
                    JOIN albumes a ON c.album_id = a.id";*/
            $sql = "call sp_Canciones_selectAll()";
            $res = $conn->query($sql);
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $obj = self::rowToDto($row);
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return [];
    }


    public static function selectAllByAlbum($id)
    {
        try {
            $lista = [];
            $conn = new Connection();
            //$sql = "SELECT * FROM canciones WHERE album_id = :varId";
            $sql = "call sp_Canciones_selectAllByAlbum(:varId)";
            $res = $conn->queryWithParams($sql, array(
                ":varId" => $id
            ));
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $obj = self::rowToDto($row);
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return [];
    }

    public static function selectById($id): ?Cancion
    {
        try {
            $conn = new Connection();
            /*$sql = "SELECT c.id, c.nombre, c.album_id, a.id as id_album, a.nombre as nombre_album
                    FROM canciones c 
                    JOIN albumes a ON c.album_id = a.id
                    WHERE c.id = :varId";*/
            $sql = "call sp_Canciones_selectById(:varId)";
            $res = $conn->queryWithParams($sql, array(
                ":varId" => $id
            ));
            if ($res->rowCount() == 0) {
                return null;
            }
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $obj = self::rowToDto($row);

            return $obj;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return null;
    }

    private static function rowToDto($row): Cancion
    {
        $objCancion = new Cancion();
        $objCancion->setId($row["id"]);
        $objCancion->setNombre($row["nombre"]);
        $objCancion->setIdAlbum($row["album_id"]);
        if(isset($row["id_album"])){
            $objCancion->setAlbum($row["id_album"], $row["nombre_album"]);
        }
        return $objCancion;
    }
}