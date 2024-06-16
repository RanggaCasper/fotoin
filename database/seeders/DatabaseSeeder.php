<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\WebsiteConf;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'username' => 'User',
            'fullname' => 'M. Irfan Rangganata',
            'email' => 'example@gmail.com',
            'no_telp' => '0812345678',
            'Role' => 'Master',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('website_conf')->insert([
            ['conf_key' => 'web_title'],
            ['conf_key' => 'web_description'],
            ['conf_key' => 'web_author'],
            ['conf_key' => 'web_keywords'],
            ['conf_key' => 'web_icon'],
            ['conf_key' => 'web_logo'],
            ['conf_key' => 'web_footer'],
        ]);
    }
}
