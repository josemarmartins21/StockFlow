<?php

namespace App\services;

use App\services\contracts\PeriodoInterface;
use App\services\DiaPeriodo;
use App\services\UltimaSemanaPeriodo;
use App\services\UltimoMesPeriodo;
use App\services\UltimoAnoPeriodo;

class PeriodoFactory
{
    public function create(string $periodo): PeriodoInterface
    {
        if ($periodo === "hoje") {
            return new DiaPeriodo;
        }

        if ($periodo === "ultima_semana") {
            return new UltimaSemanaPeriodo;
        }

        if ($periodo === "ultimo_mes") {
            return new UltimoMesPeriodo;
        }

        if ($periodo === 'ultimo_ano') {
            return new UltimoAnoPeriodo;
        }

        throw new \Exception("Periodo Inválido");

    }
}
