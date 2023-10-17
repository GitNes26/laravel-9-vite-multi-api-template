<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class SearchUserInAllDatabases
{
    public function handle($request, Closure $next)
    {
        $userId = auth()->id(); // Obtén el ID del usuario autenticado

        $connections = config('database.connections'); // Obtén todas las conexiones de bases de datos definidas en tu configuración

        foreach ($connections as $connectionName => $connectionConfig) {
            // Configura la conexión actual
            config(['database.default' => $connectionName]);

            // Realiza una consulta en la tabla "users" de la base de datos actual
            $user = DB::table('users')->where('id', $userId)->first();

            if ($user) {
                // El usuario existe en esta base de datos
                echo "El usuario con ID $userId se encontró en la base de datos '$connectionName' en la tabla 'users'.";
                // Puedes realizar acciones adicionales si es necesario
            }
        }

        // Continúa con la solicitud
        return $next($request);
    }
}
