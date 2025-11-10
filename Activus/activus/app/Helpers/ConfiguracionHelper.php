<?php
use App\Models\ConfiguracionGym;

if (!function_exists('configuracion_activa')) {
    function configuracion_activa()
    {
        $config = cache()->get('configuracion_activa');


        if (
            !$config ||
            !ConfiguracionGym::where('ID_Configuracion_Gym', $config->ID_Configuracion_Gym ?? null)->exists()
        ) {
            $config = ConfiguracionGym::with('colorFondo')->first();


            if ($config) {
                cache()->forever('configuracion_activa', $config);
            } else {
                cache()->forget('configuracion_activa');
            }
        }

        return $config;
    }
}

if (!function_exists('es_color_oscuro')) {
    function es_color_oscuro($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) === 3) {
            $hex = preg_replace('/(.)/', '$1$1', $hex);
        }

        [$r, $g, $b] = [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];

        $luminancia = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminancia < 0.5; // true = oscuro, false = claro
    }
}