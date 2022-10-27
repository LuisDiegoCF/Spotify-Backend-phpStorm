<?php

namespace App\models\bll;

use App\models\dal\Connection;
use App\models\dto\Genero;
use PDO;
use PDOException;

class GeneroBLL {
    public static function insert ($nombre): int {
        try {
            $conn = new Connection();
            //$sql = "INSERT INTO generos (nombre) VALUES (:varNombre)";
            $sql = "call sp_Generos_insert(:varNombre)";
            $result = $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre
            ));

            $row = $result->fetch(PDO::FETCH_ASSOC);
            // last
            //return $conn->getLastInsertedId();
            return $row['lastId'];
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
        return 0;
    }

    public static function update ($nombre, $id) {
        try {
            $conn = new Connection();
            //$sql = "UPDATE generos SET nombre = :varNombre WHERE id = :varId";
            $sql = "call sp_Generos_update(:varNombre, :varId)";
            $conn->queryWithParams($sql, array(
                ":varNombre" => $nombre,
                ":varId" => $id
            ));
        } catch (PDOException $e) {
            $_SESSION["error"] = $e->getMessage();
        }
    }

    public static function delete($id) {
        try {
            $conn = new Connection();
            //$sql = "DELETE FROM generos WHERE id = :varId";
            $sql = "call sp_Generos_delete(:varId)";
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
            //$sql = "SELECT id, nombre FROM generos";
            $sql = "call sp_Generos_selectAll()";
            $res = $conn->query($sql);
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
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

    public static function selectById($id): ?Genero {
        try {
            $conn = new Connection();
            // $sql = "SELECT * FROM generos WHERE id = :varId";
            $sql = "call sp_Generos_selectById(:varId)";
            $res = $conn->queryWithParams($sql, array(
                ":varId" => $id
            ));
            if ($res->rowCount() == 0){
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

    private static function rowToDto($row): Genero {
        $objGenero = new Genero();
        $objGenero->setId($row["id"]);
        $objGenero->setNombre($row["nombre"]);
        return $objGenero;
    }
}