<?php

namespace App\parttens\factory\relatorios\contracts;

use App\parttens\factory\relatorios\contracts\PeriodoInterface;
use App\parttens\factory\relatorios\DiaPeriodo;
use App\parttens\factory\relatorios\UltimaSemanaPeriodo;
use App\parttens\factory\relatorios\UltimoMesPeriodo;
use App\parttens\factory\relatorios\UltimoAnoPeriodo;

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
