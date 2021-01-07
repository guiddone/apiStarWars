<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Http;

class SwapiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
     /**
     * swapi services.
     *
     * @return void
     */
    public function findStarshipByName($name)
    {
        dump('asdasd');die;
        $busqueda = Http::get('https://swapi.dev/api/starships/?search='.$nombre);
        return $busqueda->json();
        
        //
    }

     /**
     * swapi services.
     *
     * @return void
     */
    public function findVehicleByName($name)
    {
        $busqueda = Http::get('https://swapi.dev/api/vehicles/?search='.$nombre);
        return $busqueda->json();
        
        //
    }
}
