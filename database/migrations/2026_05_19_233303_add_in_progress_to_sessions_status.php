<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Extend the sessions.status enum to include 'in_progress'.
 *
 * 'active'      = at least one party has joined the Agora channel
 * 'in_progress' = tutor has explicitly started the session (billing clock running)
 *
 * MySQL/MariaDB: ALTER TABLE … MODIFY COLUMN rewrites the enum definition.
 * SQLite (tests): SQLite stores enums as TEXT so no migration is needed, but
 *                 we still run the check to be safe.
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("
                ALTER TABLE sessions
                MODIFY COLUMN status ENUM(
                    'waiting',
                    'active',
                    'in_progress',
                    'ended',
                    'abandoned',
                    'disputed'
                ) NOT NULL DEFAULT 'waiting'
            ");
        }
        // SQLite and pgsql handle open-ended string columns — no DDL needed.
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            // Move any in_progress rows back to active before removing the value
            DB::statement("UPDATE sessions SET status = 'active' WHERE status = 'in_progress'");

            DB::statement("
                ALTER TABLE sessions
                MODIFY COLUMN status ENUM(
                    'waiting',
                    'active',
                    'ended',
                    'abandoned',
                    'disputed'
                ) NOT NULL DEFAULT 'waiting'
            ");
        }
    }
};
