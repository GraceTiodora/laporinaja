<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * MASTER SEEDER - Setup aplikasi dengan data initial yang konsisten
     */
    public function run(): void
    {
        // 1. Seed Users
        $this->seedUsers();

        // 2. Seed Categories
        $this->seedCategories();

        // 3. Seed Reports
        $this->seedReports();
    }

    private function seedUsers(): void
    {
        User::create([
            'name' => 'Seprian Siagian',
            'email' => 'seprian@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'bio' => 'Pengguna aktif platform',
            'phone' => '081234567890',
            'reputation' => 45,
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'bio' => 'Warga yang peduli lingkungan',
            'phone' => '081234567891',
            'reputation' => 32,
        ]);

        User::create([
            'name' => 'Ani Wijaya',
            'email' => 'ani@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'bio' => 'Aktivis sosial',
            'phone' => '081234567892',
            'reputation' => 28,
        ]);

        User::create([
            'name' => 'Rini Kusuma',
            'email' => 'rini@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'bio' => 'Administrator platform',
            'phone' => '081234567893',
            'reputation' => 100,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'bio' => 'Super Admin',
            'reputation' => 150,
        ]);
    }

    private function seedCategories(): void
    {
        $categories = [
            ['name' => 'Jalan Rusak', 'description' => 'Laporan kerusakan jalan dan infrastruktur'],
            ['name' => 'Sampah Menumpuk', 'description' => 'Laporan sampah yang tidak diangkut'],
            ['name' => 'Air Kotor', 'description' => 'Laporan pencemaran air'],
            ['name' => 'Kebakaran', 'description' => 'Laporan kebakaran atau potensi kebakaran'],
            ['name' => 'Banjir', 'description' => 'Laporan banjir atau genangan air'],
            ['name' => 'Kemacetan', 'description' => 'Laporan kemacetan lalu lintas'],
            ['name' => 'Polusi Udara', 'description' => 'Laporan polusi udara'],
            ['name' => 'Keamanan', 'description' => 'Laporan keamanan dan ketertiban'],
            ['name' => 'Fasilitas Publik', 'description' => 'Laporan kerusakan fasilitas publik'],
            ['name' => 'Lainnya', 'description' => 'Kategori lainnya'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => str()->slug($cat['name']),
                'description' => $cat['description'],
                'icon' => 'fa-' . str()->slug($cat['name']),
            ]);
        }
    }

    private function seedReports(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();

        // Report 1
        Report::create([
            'user_id' => $users[0]->id,
            'category_id' => $categories->where('name', 'Jalan Rusak')->first()->id,
            'title' => 'Lubang di Jalan Utama',
            'description' => 'Ada lubang besar di jalan utama yang membahayakan pengendara motor. Sudah ada beberapa kecelakaan kecil.',
            'location' => 'Jl. Merdeka No. 45, Kampus Timur',
            'status' => 'Baru',
            'upvotes' => 5,
            'downvotes' => 0,
        ]);

        // Report 2
        Report::create([
            'user_id' => $users[1]->id,
            'category_id' => $categories->where('name', 'Sampah Menumpuk')->first()->id,
            'title' => 'Sampah Tidak Diangkut Seminggu',
            'description' => 'Sampah di area sekitar sudah tidak diangkut selama seminggu. Bau yang tidak sedap dan menarik tikus.',
            'location' => 'Jl. Diponegoro, Blok C',
            'status' => 'Diproses',
            'upvotes' => 8,
            'downvotes' => 1,
        ]);

        // Report 3
        Report::create([
            'user_id' => $users[2]->id,
            'category_id' => $categories->where('name', 'Air Kotor')->first()->id,
            'title' => 'Air Sumur Tercemar Oli',
            'description' => 'Air sumur bor berubah warna kuning kecoklatan dan berbau. Diduga ada kebocoran dari tempat penyimpanan oli.',
            'location' => 'Perumahan Indah Jaya, RT 05',
            'status' => 'Baru',
            'upvotes' => 12,
            'downvotes' => 2,
        ]);

        // Report 4
        Report::create([
            'user_id' => $users[0]->id,
            'category_id' => $categories->where('name', 'Fasilitas Publik')->first()->id,
            'title' => 'Lampu Taman Mati Sudah Berbulan-bulan',
            'description' => 'Semua lampu di taman kota sudah tidak menyala selama 3 bulan. Area menjadi gelap dan tidak aman malam hari.',
            'location' => 'Taman Kota, Jl. Sudirman',
            'status' => 'Diproses',
            'upvotes' => 6,
            'downvotes' => 0,
        ]);

        // Report 5
        Report::create([
            'user_id' => $users[1]->id,
            'category_id' => $categories->where('name', 'Kemacetan')->first()->id,
            'title' => 'Macet Parah di Simpang Empat Setiap Jam 5-6 Sore',
            'description' => 'Setiap hari kerja dari jam 5 sampai 6 sore, simpang empat utama macet parah. Tidak ada pengatur lalu lintas.',
            'location' => 'Simpang Empat, Jl. Ahmad Yani',
            'status' => 'Baru',
            'upvotes' => 3,
            'downvotes' => 0,
        ]);
    }
}
