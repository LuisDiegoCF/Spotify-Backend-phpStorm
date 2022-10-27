<?php

namespace App\models\bll;

use App\models\dal\Connection;
use App\models\dto\Artista;
use PDO;
use PDOException;

class ArtistaBLL {
    public static function insert ($nombre, $idGenero) : int{
        try {
            $conn = new Connection();
            //$sql = "INSERT INTO artistas (nombre, genero_id) VALUES (:varNombre, :varIdGenero)";
            $sql = "call sp_Artistas_insert(:varNombre, :varIdGenero)";
            $result = $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varIdGenero" => $idGenero
            ));
            $row = $result->fetch(PDO::FETCH_ASSOC);
            //return $conn->getLastInsertedId();
            return $row['lastId'];
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return 0;
    }

    public static function update ($nombre, $idGenero, $id) {
        try {
            $conn = new Connection();
            // $sql = "UPDATE artistas SET nombre = :varNombre, genero_id = :varIdGenero WHERE id = :varId";
            $sql = "call sp_Artistas_update(:varNombre, :varIdGenero, :varId)";
            $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varIdGenero" => $idGenero,
                ":varId" => $id
            ));
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public static function delete ($id) {
        try {
            $conn = new Connection();
            //$sql = "DELETE FROM artistas WHERE id = :varId";
            $sql = "call sp_Artistas_delete(:varId)";
            $conn->queryWithParams($sql, array(
                ":varId" => $id
            ));
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public static function selectAll(): array {
        try {
            $lista = [];
            $conn = new Connection();
            /*$sql = "SELECT a.id, a.nombre, a.genero_id, g.id as id_genero ,g.nombre as nombre_genero
                    FROM artistas a 
                    join generos g on a.genero_id = g.id";*/
            $sql = "call sp_Artistas_selectAll()";
            $res = $conn->query($sql);
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                // toma una fila y convierte a un objeto
                $obj = self::rowToDto($row);
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return [];
    }

    // selectAllByGenero
    public static function selectAllByGenero($idGenero): array {
        try {
            $lista = [];
            $conn = new Connection();
            //$sql = "SELECT * FROM artistas WHERE genero_id = :varIdGenero";
            $sql = "call sp_Artistas_selectAllByGenero(:varIdGenero)";
            $res = $conn->queryWithParams($sql, array(
                ":varIdGenero" => $idGenero
            ));
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                // toma una fila y convierte a un objeto
                $obj = self::rowToDto($row);
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return [];
    }

    public static function selectById($id): ?Artista {
        try {
            $conn = new Connection();
            /*$sql = "SELECT a.id, a.nombre, a.genero_id, g.id as id_genero ,g.nombre as nombre_genero
                    FROM artistas a 
                    join generos g on a.genero_id = g.id
                    WHERE a.id = :varId"*/;
            $sql = "call sp_Artistas_selectById(:varId)";
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

    public static function rowToDto($row): Artista {
        $objArtista = new Artista();
        $objArtista->setId($row["id"]);
        $objArtista->setNombre($row["nombre"]);
        $objArtista->setIdGenero($row["genero_id"]);
        if(isset($row["id_genero"])){
            $objArtista->setGenero($row["id_genero"], $row["nombre_genero"]);
        }
        return $objArtista;
    }
}