<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $appVersion = config('app.version', '2.0.0');

        return view('settings', [
            'title' => 'Settings',
            'appVersion' => $appVersion,
        ]);
    }

    /**
     * Check database connection status.
     */
    public function checkDatabase()
    {
        try {
            DB::connection()->getPdo();

            $connection = config('database.default');
            $databaseName = config("database.connections.{$connection}.database");
            $host = config("database.connections.{$connection}.host", 'localhost');

            return response()->json([
                'connected' => true,
                'database' => $databaseName,
                'host' => $host,
                'driver' => $connection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'connected' => false,
                'error' => 'Unable to connect to database',
            ]);
        }
    }
}
