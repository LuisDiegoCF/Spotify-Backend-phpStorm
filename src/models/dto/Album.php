<?php

namespace App\models\dto;

use StdClass;

class Album {
    public $id;
    public $nombre;
    public $idArtista;
    public $artista;

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
    public function getIdArtista()
    {
        return $this->idArtista;
    }

    /**
     * @param mixed $idArtista
     */
    public function setIdArtista($idArtista)
    {
        $this->idArtista = $idArtista;
    }

    public function setArtista($id_artista, $nombre)
    {
        $this->artista = new StdClass();
        $this->artista->id = $id_artista;
        $this->artista->nombre = $nombre;
    }


}