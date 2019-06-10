<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);

        $events->Listen(BuildingMenu::class, function(BuildingMenu $event){

            $event->menu->add(
                'MENU DE NAVEGACION',
                [
                    'text' => 'Escrtorio',
                    'route' => 'home',
                    'icon' => 'dashboard'
                ],
                [
                    'text' => 'Perfil',
                    'route' => 'profile',
                    'icon' => 'user'
                ],
                'CONFIGURACION',
                [
                    'text' => 'Paises',
                    'route' => 'countries.index',
                    'icon' => 'flag'
                ],
                [
                    'text' => 'Categorias',
                    'route' => 'categories.index',
                    'icon' => 'list-ul'
                ],
                [
                    'text' => 'Metodos de Pago',
                    'route' => 'payment_methods.index',
                    'icon' => 'money'
                ],
                'IPTV',
                [
                    'text' => 'Canales',
                    'route' => 'channels.index',
                    'icon' => 'television'
                ],
                [
                    'text' => 'Planes',
                    'route' => 'plans.index',
                    'icon' => 'star'
                ],
                'NEGOCIOS',
                [
                    'text' => 'Clientes',
                    'route' => 'users.index',
                    'icon' => 'users'
                ],
                [
                    'text' => 'Pagos',
                    'route' => 'payments.index',
                    'icon' => 'credit-card'
                ]
            );

        });
    }
}
