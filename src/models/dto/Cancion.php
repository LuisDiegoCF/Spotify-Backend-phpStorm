<?php

namespace App\models\dto;

use StdClass;

class Cancion {
    public $id;
    public $nombre;
    public $idAlbum;
    public $album;

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

    /**
     * @return mixed
     */
    public function getIdAlbum()
    {
        return $this->idAlbum;
    }

    /**
     * @param mixed $idAlbum
     */
    public function setIdAlbum($idAlbum)
    {
        $this->idAlbum = $idAlbum;
    }

    public function setAlbum($id_album, $nombre_album)
    {
        $this->album = new StdClass();
        $this->album->id = $id_album;
        $this->album->nombre = $nombre_album;
    }


}