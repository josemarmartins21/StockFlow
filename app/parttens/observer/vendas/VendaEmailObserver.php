<?php
namespace App\parttens\observer\vendas;

use App\Mail\FaturaEmail;
use App\Models\Fatura;
use App\parttens\observer\vendas\contracts\VendaFaturaInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VendaEmailObserver implements VendaFaturaInterface {
    public function update(): void
    {
        $fatura = Fatura::latest()->first();
        
        Mail::to(Auth::user()->email)->send(new FaturaEmail($fatura, Auth::user()));
    }
}