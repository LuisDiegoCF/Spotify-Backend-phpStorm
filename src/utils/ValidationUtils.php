<?php

namespace App\utils;

class ValidationUtils
{
    // valida que el request tenga el campo y que no este vacio
    public static function validarRequest($request, $nombre): bool
    {
        if ( ! property_exists($request, $nombre)) {
            http_response_code(400);
            echo "$nombre es requerido";

            return false;
        }

        return true;
    }
}