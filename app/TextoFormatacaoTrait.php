<?php

namespace App;

trait TextoFormatacaoTrait
{
    public function eliminarCaracteres(string $separador, string $texto): string
    {
        $textoEmArray = explode($separador, $texto);
        
        if(count($textoEmArray) > 1) {
            return $textoEmArray[0] . " " . $textoEmArray[1];
        }  
        return $texto;
    }
}
