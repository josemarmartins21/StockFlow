<?php
namespace App\parttens\factory;



use App\parttens\factory\vendas\contracts\FileInterface;
use App\parttens\factory\vendas\PdfFile;
use Exception;

class FileFactory {
    public function create(string $type): FileInterface
    {
        if ($type === 'pdf') {
            return new PdfFile();
        }

        throw new Exception("Tipo de arquivo inválido");
        
    }
}