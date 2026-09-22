PRD: Sistem Pendaftaran Atlet Event Renang (Klub/Perkumpulan)
1. Latar Belakang
Saat ini proses pendaftaran atlet ke event lomba (renang) oleh perkumpulan/klub dilakukan secara manual, menyulitkan panitia dalam mengelola data limit waktu, kategori umur (KU), dan rekapitulasi akhir per klub. Sistem ini bertujuan mendigitalkan seluruh alur mulai dari publikasi event, pendaftaran atlet oleh klub, hingga ekspor data final oleh admin.

2. Tujuan Produk
Menyediakan katalog event & jadwal yang bisa diakses publik.
Memungkinkan perkumpulan mendaftarkan atlet secara mandiri (self-service) dengan validasi otomatis.
Mengurangi kesalahan input data limit waktu lomba melalui auto-match dan histori data.
Memberi admin kontrol penuh atas master lomba per KU dan kemudahan ekspor data ke Excel multi-sheet per klub.
3. Peran Pengguna (User Roles)
Role	Deskripsi
Guest / Publik	Pengunjung tanpa akun, hanya bisa melihat katalog event & jadwal
User / Perkumpulan	Klub yang sudah memiliki akun, mendaftarkan atlet & mengelola entri lomba
Admin	Pengelola sistem, membuat event, master lomba, dan melakukan ekspor data
4. Alur Pengguna (User Flows)
4.1 Guest / Publik
Melihat katalog event & jadwal (read-only, tanpa login).
Klik "Daftar Atlet" → sistem menampilkan pop-up login akun klub.
Jika belum punya akun → tombol/link "Kontak Admin via WhatsApp" untuk permintaan pembuatan akun.
4.2 User / Perkumpulan (setelah login)
Pilih Event → sistem melakukan pengecekan batas waktu pendaftaran (deadline) di server.
Input Atlet → field nama atlet mendukung auto-complete berdasarkan Master Riwayat (data atlet yang pernah didaftarkan sebelumnya).
Pilih KU (Kelompok Umur) → dropdown nomor lomba berubah secara dinamis mengikuti KU yang dipilih.
Input Limit Waktu:
Sistem melakukan auto-match dengan data limit sebelumnya, atau
Opsi A: jika jarak lomba berbeda dari riwayat → default status NT (No Time) + notifikasi ke user.
Kelola Data (Edit/Hapus):
Sebelum deadline → data bisa diedit/dihapus.
Setelah deadline → data terkunci (locked), tidak bisa diubah.
4.3 Admin
Buat Event & mengatur Master Lomba per KU (nomor lomba, jarak, gaya, dsb).
Import Excel data lomba lama → tersimpan ke Database Master Riwayat (sumber auto-complete & auto-match).
Export Excel → backend men-generate file .xlsx otomatis, terpisah per sheet untuk masing-masing klub (multi-sheet per club).
5. Functional Requirements
5.1 Guest
FR-1: Sistem menampilkan katalog event & jadwal tanpa perlu login.
FR-2: Aksi "Daftar Atlet" memicu modal login.
FR-3: Modal login menyediakan opsi kontak admin via WhatsApp bagi yang belum memiliki akun.
5.2 User / Perkumpulan
FR-4: Sistem memvalidasi deadline pendaftaran per event sebelum mengizinkan input data.
FR-5: Form input atlet menyediakan auto-complete berbasis Master Riwayat.
FR-6: Dropdown nomor lomba ter-update otomatis (dependent dropdown) berdasarkan KU yang dipilih.
FR-7: Sistem melakukan auto-match limit waktu berdasarkan riwayat atlet & jarak lomba.
FR-8: Jika jarak lomba tidak memiliki riwayat yang cocok, sistem otomatis mengisi status NT dan mengirim notifikasi ke user.
FR-9: Sistem mengunci (read-only) seluruh data pendaftaran bagi User/Perkumpulan begitu deadline event terlampaui.
FR-10: Sebelum deadline, user dapat mengedit dan menghapus data atlet/entri lomba miliknya.
FR-10a: Setiap entri pendaftaran atlet yang diinput user langsung tersimpan/terdaftar secara otomatis (auto-approved), tanpa memerlukan proses review atau approval manual dari Admin.
5.3 Admin
FR-11: Admin dapat membuat event baru dan mengatur master nomor lomba per KU.
FR-12: Admin dapat mengimpor file Excel berisi data lomba lama ke Database Master Riwayat.
FR-13: Admin dapat mengekspor seluruh data pendaftaran event menjadi file .xlsx, dengan sheet terpisah per klub.
FR-14: Admin memiliki hak override untuk mengedit/menghapus data pendaftaran meskipun status sudah locked pasca-deadline. Aksi override ini sebaiknya tercatat pada log audit (siapa, kapan, perubahan apa).
FR-15: Pembuatan akun klub baru dilakukan sepenuhnya secara manual oleh Admin melalui request via WhatsApp — tidak ada proses approval atau self-registration di dalam sistem.
6. Non-Functional Requirements
Keamanan: Autentikasi wajib untuk akses fitur pendaftaran (role User/Admin); guest hanya akses read-only.
Performa: Pengecekan deadline & auto-match harus real-time (respons < 2 detik) saat input.
Reliabilitas: Proses generate Excel multi-sheet tidak boleh gagal untuk event dengan banyak klub/atlet.
Auditability: Setiap perubahan/hapus data sebelum deadline sebaiknya tercatat (log) untuk keperluan audit admin.
7. Kebutuhan Data (High-Level)
Master Event: nama event, tanggal, deadline pendaftaran.
Master Lomba per KU: KU, nomor lomba, jarak, gaya.
Master Riwayat Atlet: nama atlet, klub, histori limit waktu per nomor lomba.
Entri Pendaftaran: atlet, event, KU, nomor lomba, limit waktu, status (Normal/NT), status lock.
8. Metrik Keberhasilan
Berkurangnya kesalahan input limit waktu (dibanding proses manual).
Waktu admin untuk rekap hasil akhir (export Excel) berkurang signifikan.
Tingkat penggunaan auto-complete/auto-match oleh user (adoption rate).