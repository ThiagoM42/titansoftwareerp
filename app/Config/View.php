<?php

namespace Config;

class View
{
    public static function render($view, $data = []): void
    {
        extract($data);

        ob_start();

        // echo ($view);
        require __DIR__ . '/../Views/' . $view . '.php';

        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';;
    }
}
