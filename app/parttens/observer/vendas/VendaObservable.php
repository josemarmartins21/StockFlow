<?php
namespace App\parttens\observer\vendas;
use App\parttens\observer\vendas\contracts\VendaInterface;


class VendaObservable {
    private $observers = [];
    public function __construct(
        private int $numeroVendas,
    )
    {
    }

    public function notifyObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }

    public function setNumeroVendas(int $numeroVendas): void
    {
        if ($this->numeroVendas < $numeroVendas) {
            $this->numeroVendas = $numeroVendas;

            $this->notifyObservers();
        }
    }

    public function addObservers(VendaFaturaObserver $observer): void
    {
        $this->observers[] = $observer;
    }
}