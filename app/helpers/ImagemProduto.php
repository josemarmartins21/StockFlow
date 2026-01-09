<?php

namespace App\Helpers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;

class ImagemProduto {
    private string $imagemName;

    public function __construct(StoreProdutoRequest | UpdateProdutoRequest $request)
    {
        $this->validate($request);
        
    }

    /**
     * Valida a imagem a ser enviada
     * @param StoreProdutoRequest  UpdateProdutoRequest $request
     * 
     * 
     * @return void
     */
    public function validate(StoreProdutoRequest | UpdateProdutoRequest $request): void {       
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
     * Salva a imagem na diretório correcto
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