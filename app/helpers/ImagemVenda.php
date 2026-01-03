<?php

namespace App\Helpers;

use App\Http\Requests\StoreVendaRequest;

class ImagemVenda {
    private string $imagemName;

    public function __construct(StoreVendaRequest $request, string $image)
    {
        $this->validate($request, $image);
    }

    /**
     * Valida a imagem a ser enviada
     * @param StoreVendaRequest $request
     * @param string $image
     * 
     * @return void
     */
    public function validate(StoreVendaRequest $request, string $image): void {       
        if ($request->hasFile($image) AND $request->file($image)->isValid()) {
            $extension = $request->file($image)->extension();
           
            $newName = md5($request->file($image)->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $this->setImageName($newName);
        }

    }

    public function setImageName(string $image): void
    {
        $this->imagemName = $image;
    }

    public function getName(): string
    {
        return $this->imagemName;
    }
}