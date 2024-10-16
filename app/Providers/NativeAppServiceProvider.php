<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Menu\Menu;

use Native\Laravel\Facades\Notification;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        /*MenuBar::create()
            ->label('Mod TF2 Status: OK');*/

        Menu::new()
            ->register();
        Window::open()
            ->width(1280)
            ->height(720);
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
