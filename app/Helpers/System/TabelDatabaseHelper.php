<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper TabelDatabaseHelper
    |----------------------------------------------------------------------
    |


        $tables = list_tables();
        // contoh hasil: ['users', 'posts', 'orders']
        // php artisan tinker --execute="print_r(list_tables());"


        // $fields = list_fields('users');
        // contoh hasil: ['id', 'name', 'email', 'password', 'created_at', 'updated_at']


*/

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Mendapatkan semua tabel yang ada di database.
 *
 * @return array
 */
if (!function_exists('list_tables')) {
    function list_tables()
    {
        $database = DB::getDatabaseName();
        $tables = DB::select("SHOW TABLES");

        $keyName = "Tables_in_{$database}";
        $result = [];

        foreach ($tables as $table) {
            $result[] = $table->$keyName;
        }

        return $result;
    }
}

/**
 * Mendapatkan semua field dari sebuah tabel.
 *
 * @param string $table
 * @return array
 */
if (!function_exists('list_fields')) {
    function list_fields($table)
    {
        $columns = DB::select("SHOW COLUMNS FROM `$table`");
        $result = [];

        foreach ($columns as $col) {
            // Pastikan kita bisa akses dengan aman
            $arr = (array) $col;

            // Cari key yang cocok untuk nama field
            $fieldKey = null;
            $typeKey  = null;

            foreach ($arr as $key => $value) {
                $lower = strtolower($key);
                if ($lower === 'field') $fieldKey = $key;
                if ($lower === 'type')  $typeKey  = $key;
            }

            if ($fieldKey && $typeKey) {
                $field = $arr[$fieldKey];
                $type  = $arr[$typeKey];
                $result[$field] = $type;
            }
        }

        return $result;
    }
}

/**
 * Cek apakah sebuah tabel ada.
 */
if (!function_exists('cek_tabel')) {
    function cek_tabel($tableName)
    {
        $tables = list_tables();
        return in_array($tableName, $tables);
    }
}

/**
 * Cek apakah sebuah field ada di tabel tertentu.
 */
if (!function_exists('cek_field')) {
    function cek_field($tableName, $fieldName)
    {
        if (!cek_tabel($tableName)) {
            return false; // tabel tidak ada
        }

        $fields = list_fields($tableName);
        return in_array($fieldName, $fields);
    }
}

/**
 * Helper untuk menampilkan semua tabel & field seperti di command.
 *
 * @return array
 */
if (!function_exists('cek_tabel_database')) {
    function cek_tabel_database()
    {
        $tables = list_tables();
        $result = [];

        foreach ($tables as $table) {
            $fields = list_fields($table);
            $result[$table] = $fields ?: ['(Tidak ada field ditemukan)'];
        }

        return $result;
    }
}

if (!function_exists('fix_auto_ids')) {
    /**
     * Memperbaiki semua kolom `id` agar menjadi AUTO_INCREMENT PRIMARY KEY.
     * Aman dari error "Multiple primary key defined".
     * @return array daftar tabel yang berhasil diperbaiki
     */
    function fix_auto_ids(): array
    {
        $fixed = [];
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . env('DB_DATABASE');
        $tables = array_map(fn($t) => $t->$key, $tables);

        foreach ($tables as $table) {
            try {
                // Lewati tabel tanpa kolom id
                if (!Schema::hasColumn($table, 'id')) continue;

                // Cek apakah sudah auto_increment
                $info = DB::selectOne("
                    SELECT EXTRA
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = ?
                    AND COLUMN_NAME = 'id'
                ", [$table]);

                $isAuto = isset($info->EXTRA) && str_contains($info->EXTRA, 'auto_increment');

                if (!$isAuto) {
                    // Cek apakah tabel sudah punya primary key
                    $hasPrimary = DB::selectOne("
                        SELECT COUNT(*) AS cnt
                        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
                        WHERE TABLE_SCHEMA = DATABASE()
                          AND TABLE_NAME = ?
                          AND CONSTRAINT_TYPE = 'PRIMARY KEY'
                    ", [$table]);

                    if ($hasPrimary->cnt > 0) {
                        // Sudah ada PRIMARY KEY lain → ubah tanpa PRIMARY
                        DB::statement("
                            ALTER TABLE `{$table}`
                            MODIFY `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
                        ");
                        info("🟡 {$table}: id diubah jadi AUTO_INCREMENT (tanpa PRIMARY KEY baru).");
                    } else {
                        // Belum ada PK → buat id jadi AUTO_INCREMENT PRIMARY KEY
                        DB::statement("
                            ALTER TABLE `{$table}`
                            MODIFY `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
                        ");
                        info("🟢 {$table}: id dijadikan AUTO_INCREMENT PRIMARY KEY.");
                    }

                    $fixed[] = $table;
                }
            } catch (Exception $e) {
                // Lewati tabel error tapi tetap lanjut
                info("⚠ {$table}: Gagal diperbaiki — {$e->getMessage()}");
            }
        }

        return $fixed;
    }
}
