<?php
/**
 * Vercel Entry Point for Laravel
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        echo "<h1>FATAL ERROR CAUGHT BY SHUTDOWN FUNCTION!</h1>";
        echo "<pre>";
        var_dump($error);
        echo "</pre>";
    }
});

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>EXCEPTION CAUGHT BY TRY-CATCH!</h1>";
    echo "<pre>" . (string) $e . "</pre>";
}
