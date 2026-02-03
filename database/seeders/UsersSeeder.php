<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('data/buku_tamu_users.csv');

        if (!file_exists($file) || !is_readable($file)) {
            throw new \Exception("File CSV tidak ditemukan atau tidak bisa dibaca.");
        }

        $header = null;
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $record = array_combine($header, $row);

                    unset($record['id']);

                    // Memastikan role_id tidak kosong dan merupakan integer
                    if (empty($record['role_id']) || !is_numeric($record['role_id'])) {
                        continue;
                    }
                    $record['password'] = Hash::make($record['password']);
                    // Format tanggal
                    $record['created_at'] = $this->convertDateTime($record['created_at'] ?? null);
                    $record['updated_at'] = $this->convertDateTime($record['updated_at'] ?? null);

                    $data[] = $record;
                }
            }
            fclose($handle);
        }

        DB::table('users')->insert($data);
    }

    private function convertDateTime($datetime)
    {
        try {
            return Carbon::createFromFormat('n/j/Y H:i', $datetime)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return now();
        }
    }
}