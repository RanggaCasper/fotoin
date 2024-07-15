<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Freelance;
use App\Models\User;
use App\Models\WebsiteConf;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

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
            'email' => 'user@gmail.com',
            'no_telp' => '0812345678',
            'Role' => 'User',
            'gender' => 'Laki - Laki',
            'email_verified_at' => now(),
            'password' => bcrypt('user'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'username' => 'Master',
            'fullname' => 'M. Irfan Rangganata',
            'email' => 'master@gmail.com',
            'no_telp' => '081323213',
            'Role' => 'Master',
            'gender' => 'Laki - Laki',
            'email_verified_at' => now(),
            'password' => bcrypt('master'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'username' => 'Admin',
            'fullname' => 'M. Irfan Rangganata',
            'email' => 'admin@gmail.com',
            'no_telp' => '08131273921',
            'Role' => 'Admin',
            'gender' => 'Laki - Laki',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'username' => 'Freelance',
            'fullname' => 'M. Irfan Rangganata',
            'email' => 'freelance@gmail.com',
            'no_telp' => '03129371293',
            'Role' => 'Freelance',
            'gender' => 'Laki - Laki',
            'email_verified_at' => now(),
            'password' => bcrypt('freelance'),
            'remember_token' => Str::random(10),
        ]);

        Freelance::create([
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie lacus dui. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin non mattis magna. Mauris enim arcu, gravida eget leo et, placerat tincidunt nisl. Fusce eget risus in ex consequat lobortis. Duis elit lorem, ullamcorper nec leo at, porta tincidunt justo. Sed pharetra, dolor at dapibus ullamcorper.',
            'foto_ktp' => 'foto_ktp/mSPF2q2tsTgLHQEtbzTAcAKjh80h4EOoeAPlLcUD.png',
            'selfie_ktp' => 'selfie_ktp/QmfHLk2PDviTmR93ew9hhx4nRSPzsxV0E2B92FVX.png',
            'nik' => '2132132131',
            'kode_pos' => '88123',
            'provinsi' => 'BALI',
            'kota' => 'KOTA DENPASAR',
            'kecamatan' => 'DENPASAR TIMUR',
            'desa' => 'PENATIH',
            'alamat' => 'Jl. Trengguli Gg. IV NO.26',
            'status' => 'on',
            'portofolio' => 'portofolio_pendaftaran/gBQwcCE4pWeBZ35tOlImvAIxMwYqu2epTPg2iM19.png',
            'user_id' => User::where('role', 'Freelance')->first()->id,
        ]);

        Category::create([
            'name' => 'Weeding',
            'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-flower"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M12 2a3 3 0 0 1 3 3c0 .562 -.259 1.442 -.776 2.64l-.724 1.36l1.76 -1.893c.499 -.6 .922 -1 1.27 -1.205a2.968 2.968 0 0 1 4.07 1.099a3.011 3.011 0 0 1 -1.09 4.098c-.374 .217 -.99 .396 -1.846 .535l-2.664 .366l2.4 .326c1 .145 1.698 .337 2.11 .576a3.011 3.011 0 0 1 1.09 4.098a2.968 2.968 0 0 1 -4.07 1.098c-.348 -.202 -.771 -.604 -1.27 -1.205l-1.76 -1.893l.724 1.36c.516 1.199 .776 2.079 .776 2.64a3 3 0 0 1 -6 0c0 -.562 .259 -1.442 .776 -2.64l.724 -1.36l-1.76 1.893c-.499 .601 -.922 1 -1.27 1.205a2.968 2.968 0 0 1 -4.07 -1.098a3.011 3.011 0 0 1 1.09 -4.098c.374 -.218 .99 -.396 1.846 -.536l2.664 -.366l-2.4 -.325c-1 -.145 -1.698 -.337 -2.11 -.576a3.011 3.011 0 0 1 -1.09 -4.099a2.968 2.968 0 0 1 4.07 -1.099c.348 .203 .771 .604 1.27 1.205l1.76 1.894c-1 -2.292 -1.5 -3.625 -1.5 -4a3 3 0 0 1 3 -3z" /></svg>',
            'image' => 'asset/img/service/service-06.jpg',
        ]);

        DB::table('categorys')->insert([
            [
                'name' => 'Year Book',
                'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-album"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M12 4v7l2 -2l2 2v-7" /></svg>',
                'image' => 'asset/img/service/service-06.jpg'
            ],
            [
                'name' => 'Weeding',
                'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-flower"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M12 2a3 3 0 0 1 3 3c0 .562 -.259 1.442 -.776 2.64l-.724 1.36l1.76 -1.893c.499 -.6 .922 -1 1.27 -1.205a2.968 2.968 0 0 1 4.07 1.099a3.011 3.011 0 0 1 -1.09 4.098c-.374 .217 -.99 .396 -1.846 .535l-2.664 .366l2.4 .326c1 .145 1.698 .337 2.11 .576a3.011 3.011 0 0 1 1.09 4.098a2.968 2.968 0 0 1 -4.07 1.098c-.348 -.202 -.771 -.604 -1.27 -1.205l-1.76 -1.893l.724 1.36c.516 1.199 .776 2.079 .776 2.64a3 3 0 0 1 -6 0c0 -.562 .259 -1.442 .776 -2.64l.724 -1.36l-1.76 1.893c-.499 .601 -.922 1 -1.27 1.205a2.968 2.968 0 0 1 -4.07 -1.098a3.011 3.011 0 0 1 1.09 -4.098c.374 -.218 .99 -.396 1.846 -.536l2.664 -.366l-2.4 -.325c-1 -.145 -1.698 -.337 -2.11 -.576a3.011 3.011 0 0 1 -1.09 -4.099a2.968 2.968 0 0 1 4.07 -1.099c.348 .203 .771 .604 1.27 1.205l1.76 1.894c-1 -2.292 -1.5 -3.625 -1.5 -4a3 3 0 0 1 3 -3z" /></svg>',
                'image' => 'asset/img/service/service-06.jpg'
            ],
            [
                'name' => 'Graduation',
                'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-access-point"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12l0 .01" /><path d="M14.828 9.172a4 4 0 0 1 0 5.656" /><path d="M17.657 6.343a8 8 0 0 1 0 11.314" /><path d="M9.168 14.828a4 4 0 0 1 0 -5.656" /><path d="M6.337 17.657a8 8 0 0 1 0 -11.314" /></svg>',
                'image' => 'asset/img/service/service-06.jpg'
            ],
            [
                'name' => 'Event',
                'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2z" /></svg>',
                'image' => 'asset/img/service/service-06.jpg'
            ],
            [
                'name' => 'Pre-Wedding',
                'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-confetti"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h2" /><path d="M5 4v2" /><path d="M11.5 4l-.5 2" /><path d="M18 5h2" /><path d="M19 4v2" /><path d="M15 9l-1 1" /><path d="M18 13l2 -.5" /><path d="M18 19h2" /><path d="M19 18v2" /><path d="M14 16.518l-6.518 -6.518l-4.39 9.58a1 1 0 0 0 1.329 1.329l9.579 -4.39z" /></svg>',
                'image' => 'asset/img/service/service-06.jpg'
            ],
            [
                'name' => 'Commercial',
                'icon' => '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-ad"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M7 15v-4a2 2 0 0 1 4 0v4" /><path d="M7 13l4 0" /><path d="M17 9v6h-1.5a1.5 1.5 0 1 1 1.5 -1.5" /></svg>',
                'image' => 'asset/img/service/service-06.jpg'
            ],
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

        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
        ]);
    }
}
