<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Organization;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Roles & Permissions
        $this->createRolesAndPermissions();

        // 2. Create Users
        $this->createUsers();

        // 3. Create Categories
        $categories = $this->createCategories();

        // 4. Create Tags
        $tags = $this->createTags();

        // 5. Create Organizations
        $this->createOrganizations();

        // 6. Create Posts
        $this->createPosts($categories, $tags);

        // 7. Create Comments
        $this->createComments();

        // 8. Create Agendas
        $this->createAgendas();

        // 9. Create Achievements
        $this->createAchievements();

        // 10. Create Announcements
        $this->createAnnouncements();

        // 11. Create Contacts
        $this->createContacts();

        // Di method run(), tambahkan:
        $this->createOrganizationGalleries();

        $this->command->info('✅ All data seeded successfully!');
    }

    private function createRolesAndPermissions(): void
    {
        // Create permissions
        $permissions = [
            'view posts', 'create posts', 'edit posts', 'delete posts',
            'view comments', 'approve comments', 'delete comments',
            'view users', 'create users', 'edit users', 'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        // Assign all permissions to super-admin
        $superAdmin->givePermissionTo(Permission::all());

        // Assign basic permissions to admin
        $admin->givePermissionTo(['view posts', 'create posts', 'edit posts', 'view comments']);

        $this->command->info('   ✓ Roles & Permissions created');
    }

    private function createUsers(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@school.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => true,
            ]
        );
        $superAdmin->assignRole('super-admin');

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => true,
            ]
        );
        $admin->assignRole('admin');

        // Some teachers
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "teacher{$i}@school.com"],
                [
                    'name' => "Teacher {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'status' => true,
                ]
            );
        }

        $this->command->info('   ✓ Users created');
    }

    private function createCategories(): Collection
    {
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik', 'description' => 'Berita seputar akademik', 'order' => 1, 'status' => 1],
            ['name' => 'Kegiatan Sekolah', 'slug' => 'kegiatan-sekolah', 'description' => 'Kegiatan dan event', 'order' => 2, 'status' => 1],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Prestasi siswa', 'order' => 3, 'status' => 1],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Berita olahraga', 'order' => 4, 'status' => 1],
            ['name' => 'Seni & Budaya', 'slug' => 'seni-budaya', 'description' => 'Kegiatan seni', 'order' => 5, 'status' => 1],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman penting', 'order' => 6, 'status' => 1],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Berita teknologi', 'order' => 7, 'status' => 1],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        $this->command->info('   ✓ Categories created');

        return Category::all();
    }

    private function createTags(): Collection
    {
        $tags = [
            ['name' => 'Ujian', 'slug' => 'ujian'],
            ['name' => 'Lomba', 'slug' => 'lomba'],
            ['name' => 'Workshop', 'slug' => 'workshop'],
            ['name' => 'Seminar', 'slug' => 'seminar'],
            ['name' => 'Olimpiade', 'slug' => 'olimpiade'],
            ['name' => 'Festival', 'slug' => 'festival'],
            ['name' => 'PPDB', 'slug' => 'ppdb'],
            ['name' => 'Beasiswa', 'slug' => 'beasiswa'],
            ['name' => 'Science', 'slug' => 'science'],
            ['name' => 'Technology', 'slug' => 'technology'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }

        $this->command->info('   ✓ Tags created');

        return Tag::all();
    }

    private function createOrganizations(): void
    {
        $orgs = [
            ['name' => 'OSIS', 'slug' => 'osis', 'description' => 'Organisasi Siswa Intra Sekolah', 'status' => 1],
            ['name' => 'MPK', 'slug' => 'mpk', 'description' => 'Majelis Perwakilan Kelas', 'status' => 1],
            ['name' => 'Pramuka', 'slug' => 'pramuka', 'description' => 'Gerakan Pramuka', 'status' => 1],
            ['name' => 'PMR', 'slug' => 'pmr', 'description' => 'Palang Merah Remaja', 'status' => 1],
        ];

        foreach ($orgs as $org) {
            Organization::firstOrCreate(['slug' => $org['slug']], $org);
        }

        $this->command->info('   ✓ Organizations created');
    }

    private function createPosts($categories, $tags): void
    {
        $users = User::role(['admin', 'super-admin'])->get();

        $posts = [
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) 2026 Telah Dibuka',
                'slug' => 'ppdb-2026-dibuka',
                'excerpt' => 'Sekolah kami dengan bangga mengumumkan dibukanya pendaftaran peserta didik baru untuk tahun ajaran 2026/2027.',
                'content' => 'Sekolah kami dengan bangga mengumumkan dibukanya Pendaftaran Peserta Didik Baru (PPDB) untuk tahun ajaran 2026/2027.

Proses pendaftaran dapat dilakukan melalui dua cara:
1. **Online**: Melalui website resmi sekolah
2. **Offline**: Datang langsung ke sekolah

Persyaratan:
- Fotokopi akta kelahiran
- Fotokopi Kartu Keluarga
- Fotokopi Ijazah dan SKHUN
- Pas foto 3x4 sebanyak 3 lembar

Jadwal Penting:
- Pendaftaran: 1 Juli - 31 Agustus 2026
- Tes Seleksi: 5-7 September 2026
- Pengumuman: 10 September 2026

Untuk informasi lebih lanjut, silakan hubungi kontak PPDB di nomor 021-12345678.',
                'category_id' => $categories->where('slug', 'akademik')->first()->id,
                'status' => 'published',
                'featured' => true,
                'breaking_news' => true,
                'publish_date' => now()->subDays(2),
            ],
            [
                'title' => 'Jadwal Ujian Tengah Semester (UTS) Ganjil 2026',
                'slug' => 'jadwal-uts-ganjil-2026',
                'excerpt' => 'Ujian Tengah Semester (UTS) Ganjil tahun ajaran 2026/2027 akan dilaksanakan pada tanggal 15-22 Oktober 2026.',
                'content' => 'Ujian Tengah Semester (UTS) Ganjil tahun ajaran 2026/2027 akan dilaksanakan pada:

**Tanggal**: 15-22 Oktober 2026

**Jadwal Pelajaran**:
- Senin, 15 Oktober: Matematika, Bahasa Indonesia
- Selasa, 16 Oktober: Bahasa Inggris, IPA
- Rabu, 17 Oktober: IPS, Pendidikan Agama
- Kamis, 18 Oktober: PJOK, Seni Budaya

**Persyaratan Peserta**:
1. Hadir 15 menit sebelum ujian dimulai
2. Membawa kartu pelajar
3. Membawa alat tulis sendiri

Selamat belajar dan semoga sukses!',
                'category_id' => $categories->where('slug', 'akademik')->first()->id,
                'status' => 'published',
                'featured' => false,
                'breaking_news' => false,
                'publish_date' => now()->subDays(5),
            ],
            [
                'title' => 'Juara 1 Olimpiade Matematika Tingkat Nasional',
                'slug' => 'juara-olimpiade-matematika-nasional',
                'excerpt' => 'Selamat! Siswa kami berhasil meraih juara 1 Olimpiade Matematika Tingkat Nasional.',
                'content' => 'Selamat dan sukses untuk siswa kami:

**Nama**: Ahmad Rizki Pratama
**Kelas**: XII IPA 1
**Prestasi**: Juara 1 Olimpiade Matematika Tingkat Nasional
**Penyelenggara**: Universitas Indonesia
**Tanggal**: 15 Juni 2026

Ahmad berhasil mengalahkan ratusan peserta dari seluruh Indonesia dengan skor tertinggi.

Selamat! Sekolah bangga dengan prestasimu!',
                'category_id' => $categories->where('slug', 'prestasi')->first()->id,
                'status' => 'published',
                'featured' => true,
                'breaking_news' => true,
                'publish_date' => now()->subDays(3),
            ],
            [
                'title' => 'Peringatan Hari Kemerdekaan RI ke-81',
                'slug' => 'peringatan-hut-ri-81',
                'excerpt' => 'Sekolah mengadakan berbagai perlombaan dalam rangka memeriahkan Hari Ulang Tahun Kemerdekaan RI.',
                'content' => 'Dalam rangka memeriahkan Hari Ulang Tahun Kemerdekaan RI ke-81, sekolah kami mengadakan berbagai kegiatan:

**Kegiatan**:
1. Upacara Bendera - 17 Agustus 2026
2. Lomba-lomba:
   - Lomba Balap Karung
   - Lomba Makan Kerupuk
   - Lomba Tarik Tambang
   - Lomba Kebersihan Kelas

**Hadiah**:
Juara 1-3 setiap lomba akan mendapat hadiah menarik.

Mari kita ramaikan!',
                'category_id' => $categories->where('slug', 'kegiatan-sekolah')->first()->id,
                'status' => 'published',
                'featured' => false,
                'breaking_news' => false,
                'publish_date' => now()->subDays(10),
            ],
            [
                'title' => 'Pembukaan Ekstrakurikuler Olahraga Baru',
                'slug' => 'ekskul-olahraga-baru',
                'excerpt' => 'Sekolah membuka 3 ekstrakurikuler olahraga baru: Futsal, Badminton, dan Renang.',
                'content' => 'Dalam rangka mengembangkan bakat siswa, sekolah membuka 3 ekstrakurikuler baru:

**1. Futsal**
- Jadwal: Senin & Kamis, 15.30-17.00
- Tempat: Lapangan Futsal Sekolah

**2. Badminton**
- Jadwal: Selasa & Jumat, 15.30-17.00
- Tempat: GOR Sekolah

**3. Renang**
- Jadwal: Rabu & Sabtu, 08.00-10.00
- Tempat: Kolam Renang

**Pendaftaran**:
- Dibuka untuk semua kelas
- Gratis untuk siswa aktif
- Daftar di ruang OSIS

Ayo bergabung!',
                'category_id' => $categories->where('slug', 'olahraga')->first()->id,
                'status' => 'published',
                'featured' => false,
                'breaking_news' => false,
                'publish_date' => now()->subDays(15),
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create([
                'user_id' => $users->random()->id,
                'category_id' => $postData['category_id'],
                'title' => $postData['title'],
                'slug' => $postData['slug'],
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'status' => $postData['status'],
                'featured' => $postData['featured'],
                'breaking_news' => $postData['breaking_news'],
                'publish_date' => $postData['publish_date'],
                'total_views' => rand(100, 5000),
            ]);

            // Attach random tags
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        }

        // Create more posts
        $moreTitles = [
            'Pentas Seni Tahunan 2026',
            'Libur Semester Ganjil 2026',
            'Workshop Teknologi untuk Guru',
            'Study Tour ke Yogyakarta',
            'Tim Basket Juara Turnamen',
            'Peluncuran Aplikasi School Portal',
            'Program Vaksinasi untuk Siswa',
            'Rapat Orang Tua Murid',
            'Lomba Cerdas Cermat',
            'Pembagian Raport',
        ];

        foreach ($moreTitles as $index => $title) {
            $post = Post::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $title,
                'slug' => Str::slug($title).'-'.($index + 1),
                'excerpt' => 'Ini adalah excerpt untuk '.$title.'. Silakan baca selengkapnya.',
                'content' => "Ini adalah konten untuk {$title}.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                'status' => 'published',
                'featured' => false,
                'breaking_news' => false,
                'publish_date' => now()->subDays(rand(1, 30)),
                'total_views' => rand(50, 2000),
            ]);

            $post->tags()->attach($tags->random(rand(1, 2))->pluck('id')->toArray());
        }

        $this->command->info('   ✓ Posts created (15 total)');
    }

    private function createComments(): void
    {
        $posts = Post::all();
        $users = User::all();

        $comments = [
            ['content' => 'Artikel yang sangat bermanfaat, terima kasih!', 'is_approved' => true],
            ['content' => 'Keren sekali prestasinya!', 'is_approved' => true],
            ['content' => 'Kapan pendaftaran dibuka?', 'is_approved' => true],
            ['content' => 'Informasi yang sangat jelas', 'is_approved' => true],
            ['content' => 'Apakah ada beasiswa?', 'is_approved' => false],
        ];

        foreach ($comments as $commentData) {
            Comment::create([
                'post_id' => $posts->random()->id,
                'user_id' => $users->random()->id,
                'name' => 'User '.rand(1, 10),
                'email' => 'user'.rand(1, 10).'@example.com',
                'content' => $commentData['content'],
                'is_approved' => $commentData['is_approved'],
                'ip_address' => '127.0.0.1',
            ]);
        }

        $this->command->info('   ✓ Comments created');
    }

    private function createAgendas(): void
    {
        $users = User::role(['admin', 'super-admin'])->get();

        $agendas = [
            [
                'title' => 'Upacara Bendera Setiap Senin',
                'description' => 'Upacara bendera rutin setiap hari Senin pagi',
                'start_date' => now()->addDays(1)->setTime(7, 0),
                'end_date' => now()->addDays(1)->setTime(8, 0),
                'location' => 'Lapangan Sekolah',
                'status' => 'published',
            ],
            [
                'title' => 'Rapat Dewan Guru',
                'description' => 'Rapat koordinasi bulanan dewan guru',
                'start_date' => now()->addDays(3)->setTime(13, 0),
                'end_date' => now()->addDays(3)->setTime(16, 0),
                'location' => 'Ruang Guru',
                'status' => 'published',
            ],
            [
                'title' => 'Ujian Tengah Semester (UTS)',
                'description' => 'Ujian Tengah Semester Ganjil 2026',
                'start_date' => now()->addDays(10)->setTime(7, 30),
                'end_date' => now()->addDays(17)->setTime(12, 0),
                'location' => 'Ruang Kelas',
                'status' => 'published',
            ],
            [
                'title' => 'Peringatan Hari Guru Nasional',
                'description' => 'Acara peringatan Hari Guru Nasional',
                'start_date' => now()->addDays(15)->setTime(8, 0),
                'end_date' => now()->addDays(15)->setTime(15, 0),
                'location' => 'Aula Sekolah',
                'status' => 'published',
            ],
            [
                'title' => 'Pentas Seni Tahunan',
                'description' => 'Pentas seni tahunan menampilkan bakat siswa',
                'start_date' => now()->addDays(30)->setTime(8, 0),
                'end_date' => now()->addDays(30)->setTime(17, 0),
                'location' => 'Lapangan Sekolah',
                'status' => 'published',
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create(array_merge($agenda, [
                'user_id' => $users->random()->id,
            ]));
        }

        $this->command->info('   ✓ Agendas created (5 total)');
    }

    private function createAchievements(): void
    {
        $achievements = [
            [
                'title' => 'Juara 1 Olimpiade Matematika Nasional',
                'description' => 'Meraih juara 1 dalam Olimpiade Matematika Tingkat Nasional',
                'achiever_name' => 'Ahmad Rizki Pratama',
                'level' => 'national',
                'rank' => 1,
                'date' => now()->subDays(20),
                'status' => 'published',
            ],
            [
                'title' => 'Juara 2 Lomba Karya Ilmiah',
                'description' => 'Meraih juara 2 dalam Lomba Karya Ilmiah Remaja',
                'achiever_name' => 'Tim KIR Sekolah',
                'level' => 'regional',
                'rank' => 2,
                'date' => now()->subDays(30),
                'status' => 'published',
            ],
            [
                'title' => 'Juara 1 Lomba Basket',
                'description' => 'Tim basket putra meraih juara 1',
                'achiever_name' => 'Tim Basket Putra',
                'level' => 'regional',
                'rank' => 1,
                'date' => now()->subDays(15),
                'status' => 'published',
            ],
            [
                'title' => 'Finalis Olimpiade Fisika',
                'description' => 'Berhasil lolos ke babak final Olimpiade Fisika',
                'achiever_name' => 'Dedi Kurniawan',
                'level' => 'national',
                'rank' => 5,
                'date' => now()->subDays(60),
                'status' => 'published',
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }

        $this->command->info('   ✓ Achievements created (4 total)');
    }

    private function createAnnouncements(): void
    {
        $announcements = [
            [
                'title' => 'Penerimaan Peserta Didik Baru 2026',
                'content' => 'Pendaftaran PPDB 2026 telah dibuka. Silakan daftar melalui website atau datang langsung ke sekolah.',
                'priority' => 'high',
                'status' => 'published',
                'publish_date' => now()->subDays(5),
                'expired_date' => now()->addDays(30),
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'content' => 'Libur semester ganjil akan dilaksanakan pada tanggal 20 Desember 2026 - 5 Januari 2027.',
                'priority' => 'medium',
                'status' => 'published',
                'publish_date' => now()->subDays(10),
                'expired_date' => now()->addDays(60),
            ],
            [
                'title' => 'Pembayaran SPP Bulan Juli',
                'content' => 'Pembayaran SPP bulan Juli 2026 paling lambat tanggal 10 Juli 2026.',
                'priority' => 'medium',
                'status' => 'published',
                'publish_date' => now()->subDays(1),
                'expired_date' => now()->addDays(10),
            ],
            [
                'title' => 'Jadwal Ujian Tengah Semester',
                'content' => 'UTS akan dilaksanakan pada tanggal 15-22 Oktober 2026.',
                'priority' => 'high',
                'status' => 'published',
                'publish_date' => now()->subDays(15),
                'expired_date' => now()->addDays(20),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }

        $this->command->info('   ✓ Announcements created (4 total)');
    }

    private function createContacts(): void
    {
        $contacts = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '081234567890',
                'subject' => 'Pertanyaan tentang PPDB',
                'message' => 'Assalamualaikum, saya ingin bertanya tentang persyaratan PPDB 2026.',
                'is_read' => false,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'phone' => '081234567891',
                'subject' => 'Informasi Beasiswa',
                'message' => 'Apakah ada program beasiswa untuk siswa berprestasi?',
                'is_read' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@example.com',
                'phone' => '081234567892',
                'subject' => 'Kerjasama',
                'message' => 'Kami ingin mengajukan kerjasama untuk program magang.',
                'is_read' => false,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }

        $this->command->info('   ✓ Contacts created (3 total)');
    }

    // Tambahkan method baru:
    private function createOrganizationGalleries(): void
    {
        $organizations = Organization::all();

        $eventTypes = ['lomba', 'kegiatan', 'rapat', 'pelatihan', 'sosial'];
        $locations = ['Aula Sekolah', 'Lapangan Olahraga', 'Ruang Kelas', 'Lab Komputer', 'Perpustakaan'];

        foreach ($organizations as $org) {
            // Create 5-10 gallery items per organization
            $count = rand(5, 10);

            for ($i = 0; $i < $count; $i++) {
                $eventDate = now()->subDays(rand(1, 365));

                OrganizationGallery::create([
                    'organization_id' => $org->id,
                    'title' => $this->generateGalleryTitle($org->name, $eventDate),
                    'description' => 'Dokumentasi kegiatan '.$org->name.' pada '.$eventDate->format('d F Y'),
                    'image' => null, // No image in seeder
                    'event_type' => $eventTypes[array_rand($eventTypes)],
                    'event_date' => $eventDate,
                    'location' => $locations[array_rand($locations)],
                    'order' => $i,
                    'is_featured' => rand(0, 1),
                ]);
            }
        }

        $this->command->info('   ✓ Organization Galleries created');
    }

    private function generateGalleryTitle($orgName, $date): string
    {
        $templates = [
            "Kegiatan {$orgName} - {$date->format('F Y')}",
            "Dokumentasi {$orgName} {$date->format('Y')}",
            "Event {$orgName} - {$date->format('d M Y')}",
            "Aktivitas {$orgName} {$date->format('F Y')}",
        ];

        return $templates[array_rand($templates)];
    }
}
