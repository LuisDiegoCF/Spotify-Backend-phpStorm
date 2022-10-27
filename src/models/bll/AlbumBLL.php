<?php

namespace App\models\bll;

use App\models\dal\Connection;
use App\models\dto\Album;
use PDO;
use PDOException;

class AlbumBLL {
    public static function insert($nombre, $idArtista): int
    {
        try {
            $conn = new Connection();
            //$sql = "INSERT INTO albumes (nombre, artista_id) VALUES (:varNombre, :varIdArtista)";
            $sql = "call sp_Albumes_insert(:varNombre, :varIdArtista)";
            $result =  $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varIdArtista" => $idArtista
            ));
            $row = $result->fetch(PDO::FETCH_ASSOC);
            //return $conn->getLastInsertedId();
            return $row['lastId'];
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return 0;
    }

    public static function update($nombre, $idArtista, $id)
    {
        try {
            $conn = new Connection();
            //$sql = "UPDATE albumes SET nombre = :varNombre, artista_id = :varIdArtista WHERE id = :varId";
            $sql = "call sp_Albumes_update(:varNombre, :varIdArtista, :varId)";
            $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varIdArtista" => $idArtista,
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
            //$sql = "DELETE FROM albumes WHERE id = :varId";
            $sql = "call sp_Albumes_delete(:varId)";
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
            /*$sql = "SELECT al.id, al.nombre, al.artista_id, ar.id as id_artista, ar.nombre as nombre_artista
                    FROM albumes al 
                    join artistas ar on al.artista_id = ar.id";*/
            $sql = "call sp_Albumes_selectAll()";
            $result = $conn->query($sql);
            while ($row = $result->fetch()) {
                $obj = self::rowToDto($row);
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return [];
    }

    public static function selectAllByArtista($id): array
    {
        try {
            $lista = [];
            $conn = new Connection();
            /*$sql = "SELECT al.id, al.nombre, al.artista_id, ar.id as id_artista, ar.nombre as nombre_artista
                    FROM albumes al 
                    join artistas ar on al.artista_id = ar.id
                    WHERE al.artista_id = :varId";*/
            $sql = "call sp_Albumes_selectAllByArtista(:varId)";
            $result = $conn->queryWithParams($sql, array(
                ":varId" => $id
            ));
            while ($row = $result->fetch()) {
                $obj = self::rowToDto($row);
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return [];
    }

    public static function selectById($id): ?Album
    {
        try {
            $conn = new Connection();
            /*$sql = "SELECT al.id, al.nombre, al.artista_id, ar.id as id_artista, ar.nombre as nombre_artista
                    FROM albumes al 
                    join artistas ar on al.artista_id = ar.id
                    WHERE al.id = :varId";*/
            $sql = "call sp_Albumes_selectById(:varId)";

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

    private static function rowToDto($row): Album
    {
        $objAlbum = new Album();
        $objAlbum->setId($row["id"]);
        $objAlbum->setNombre($row["nombre"]);
        $objAlbum->setIdArtista($row["artista_id"]);
        if (isset($row["id_artista"])) {
            $objAlbum->setArtista($row["id_artista"], $row["nombre_artista"]);
        }
        return $objAlbum;
    }
}