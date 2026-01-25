<?php

namespace App\Helpers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use Illuminate\Foundation\Http\FormRequest;

class ImagemProduto {
    private string $imagemName;

    public function __construct(StoreProdutoRequest | UpdateProdutoRequest $request)
    {
        $this->validate($request);
        
    }

    /**
     * Valida a imagem a ser salva
     * @param FormRequest
     * 
     * 
     * @return void
     */
    public function validate(FormRequest $request): void {  
        if ($request->hasFile(PRODUTO_IMAGEM) AND $request->file(PRODUTO_IMAGEM)->isValid()) {
            $extension = $request->file(PRODUTO_IMAGEM)->extension();
            
            $newName = md5($request->file(PRODUTO_IMAGEM)->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $this->setImageName($newName);
        } 

    }

    public function setImageName(string $image): void
    {
        $this->imagemName = $image;
    }

    public function getName(): string
    {
        if (empty($this->imagemName)) {
            return '';
        }
        return $this->imagemName;
    }

    /**
     * Salva a imagem no diretório correcto
     * @param StoreProdutoRequest $request
     * 
     * @return void
     */
    public function save(StoreProdutoRequest | UpdateProdutoRequest $request): void
    {
        if (!empty($this->getName())) {
            // Salvar a imagem
            $request->file(PRODUTO_IMAGEM)->move(public_path('/assets/imagens/produtos'), $this->getName());
        }
    }
}