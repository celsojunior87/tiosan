<?php

namespace App\Providers;

use App\Compra;
use App\Estabelecimento;
use App\Estoque;
use App\Fornecedor;
use App\HistoricoCompra;
use App\Observers\EmpresaObserver;
use App\Produto;
use App\TipoProduto;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->loadModelsObservables();
    }

    private function loadModelsObservables()
    {

    }
}
