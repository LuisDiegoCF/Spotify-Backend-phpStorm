<?php


namespace App\models\dto;
use stdClass;

class Artista {
    public $id;
    public $nombre;
    public $idGenero;
    public $genero;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getIdGenero()
    {
        return $this->idGenero;
    }

    /**
     * @param mixed $idGenero
     */
    public function setIdGenero($idGenero)
    {
        $this->idGenero = $idGenero;
    }

    public function setGenero($generoId, $nombre)
    {
        $this->genero = new StdClass();
        $this->genero->id = $generoId;
        $this->genero->nombre = $nombre;
    }


}