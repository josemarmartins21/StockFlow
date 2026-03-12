<?php
namespace App\parttens\factory\vendas\contracts;


interface FileInterface {
    public function salvar($ids = []): void;
}