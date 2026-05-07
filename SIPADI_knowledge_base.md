# SIPADI — Knowledge Base untuk Development

> Dokumen ini merangkum seluruh rancangan sistem SIPADI (Sistem Informasi Produksi Padi dan Penjualan) sebagai acuan tunggal selama proses coding. Setiap keputusan desain, nama entitas, relasi, dan alur proses telah dikunci di sini agar konsisten di seluruh lapisan sistem (Controller, Model, View, Database).

---

## 1. DAFTAR AKTOR DAN PERAN

| Aktor | Peran dalam Sistem | Modul yang Diakses |
|---|---|---|
| Ketua Kelompok Tani | Admin tertinggi, menyetujui laporan dan mengelola hak akses | Laporan Operasional, Hak Akses Pengguna |
| Staf Operasional Produksi | Mencatat data pertanian, bibit, panen, dan memantau cuaca | Data Pertanian & Bibit, Data Panen, Informasi Cuaca |
| Staf Operasional Penjualan | Memproses konfirmasi transaksi dan mengelola stok beras | Transaksi & Stok Beras |
| Staf Operasional Keuangan | Mencatat arus kas, menghitung bagi hasil, membuat laporan | Arus Kas, Pembagian Hasil, Laporan Operasional |
| Pelanggan | Aktor eksternal yang melakukan pemesanan beras secara daring | E-Commerce (Katalog & Pesanan) |

---

## 2. DAFTAR USE CASE DAN CONTROLLER

| No | Nama Use Case | Controller | Aktor Utama |
|---|---|---|---|
| 1 | Autentikasi | `AutentikasiController` | Semua Aktor |
| 2 | Pengelolaan Data Pertanian dan Bibit | `PertanianController` | Staf Produksi |
| 3 | Pemantauan Informasi Cuaca | `CuacaController` | Staf Produksi |
| 4 | Pengelolaan Data Panen | `PanenController` | Staf Produksi |
| 5 | Proses Transaksi dan Stok Beras | `TransaksiController` | Pelanggan, Staf Penjualan |
| 6 | Pembuatan Arus Kas Keuangan | `KeuanganController` | Staf Keuangan |
| 7 | Pembagian Hasil | `BagiHasilController` | Staf Keuangan |
| 8 | Pembuatan Laporan Operasional | `LaporanController` | Staf Keuangan, Ketua |
| 9 | Hak Akses Pengguna | `PenggunaController` | Ketua |

---

## 3. STRUKTUR DATABASE (MODEL / ENTITAS)

> **Aturan Penamaan:** Gunakan nama di bawah ini secara konsisten di migration, model, dan controller. Jangan campur nama lama (`BiayaOperasional`) dengan nama baru (`ArusKas`).

### 3.1 Tabel `pengguna` (Model: `Pengguna`)
```
id          : INT (PK, Auto Increment)
username    : STRING (UNIQUE) ← gunakan "username", bukan "NIK"
password    : STRING (hashed, gunakan bcrypt/hash)
role        : STRING (enum: 'ketua', 'staf_produksi', 'staf_penjualan', 'staf_keuangan')
```
**Catatan:** Password wajib di-hash sebelum disimpan (lihat sequence Hak Akses — `hashKataSandi()`).

---

### 3.2 Tabel `pelanggan` (Model: `Pelanggan`)
```
id      : INT (PK, Auto Increment)
nama    : STRING
kontak  : STRING
alamat  : STRING
```
**Catatan:** Pelanggan adalah aktor eksternal (e-commerce). Tidak masuk tabel `pengguna` karena tidak memiliki role internal.

---

### 3.3 Tabel `anggota_petani` (Model: `AnggotaPetani`)
```
id          : INT (PK, Auto Increment)
nama_petani : STRING
luas_lahan  : FLOAT (dalam satuan tumbak)
```

---

### 3.4 Tabel `alokasi_bibit` (Model: `AlokasiBibit`)
```
id              : INT (PK, Auto Increment)
id_petani       : INT (FK → anggota_petani.id)
musim_tanam     : STRING (contoh: "2024-Ganjil")
jumlah_bibit    : FLOAT
```
**Relasi:** Satu petani bisa menerima banyak alokasi bibit (1 AnggotaPetani → 0..* AlokasiBibit).

---

### 3.5 Tabel `data_panen` (Model: `DataPanen`)
```
id          : INT (PK, Auto Increment)
id_petani   : INT (FK → anggota_petani.id)
musim_tanam : STRING
total_panen : FLOAT (dalam satuan kg/ton)
```
**Relasi:** Satu petani bisa menyetorkan banyak data panen (1 AnggotaPetani → 0..* DataPanen).
**Catatan:** Saat form panen dibuka, sistem harus mengambil referensi data bibit petani yang bersangkutan (`querySelect(tabel_alokasi_bibit)`) untuk ditampilkan sebagai acuan.

---

### 3.6 Tabel `stok_beras` (Model: `StokBeras`)
```
id                  : INT (PK, Auto Increment)
ketersediaan_stok   : FLOAT (dalam satuan kg)
```
**Catatan:** Stok dikurangi sementara saat pesanan masuk (`status='Menunggu'`), dan dikurangi permanen saat staf mengkonfirmasi pesanan (`status='Selesai'`).

---

### 3.7 Tabel `transaksi` (Model: `Transaksi`)
```
id              : INT (PK, Auto Increment)
id_pelanggan    : INT (FK → pelanggan.id)
tanggal_pesanan : DATE
jumlah_pesanan  : INT
status_pesanan  : STRING (enum: 'Menunggu', 'Selesai', 'Dibatalkan')
```
**Relasi:**
- Satu pelanggan bisa melakukan banyak transaksi (1 Pelanggan → 0..* Transaksi)
- Satu stok beras bisa berkurang oleh banyak transaksi (1 StokBeras → 0..* Transaksi)

---

### 3.8 Tabel `arus_kas` (Model: `ArusKas`)
> ⚠️ Nama resmi adalah `arus_kas`. Jangan gunakan nama `biaya_operasional` di kode manapun.

```
id              : INT (PK, Auto Increment)
tanggal         : DATE
jenis_transaksi : STRING (enum: 'pemasukan', 'pengeluaran')
nominal         : FLOAT (wajib positif, validasi di controller)
keterangan      : STRING
```
**Catatan:** Tabel ini mencatat SEMUA arus keuangan, baik pemasukan dari penjualan maupun pengeluaran operasional. Bukan hanya biaya saja.

---

### 3.9 Tabel `pembagian_hasil` (Model: `PembagianHasil`)
```
id                  : INT (PK, Auto Increment)
id_petani           : INT (FK → anggota_petani.id)
musim_tanam         : STRING
proporsi_panen      : FLOAT (persentase kontribusi panen petani)
alokasi_keuntungan  : FLOAT (nominal rupiah yang diterima petani)
total_keuntungan    : FLOAT (total keuntungan kelompok periode tersebut)
```
> ⚠️ Ganti `rincian_bagian: JSON` menjadi kolom-kolom terpisah di atas. JSON tidak digunakan.

**Dependency:** Use case ini TIDAK BISA dijalankan jika data `arus_kas` untuk `musim_tanam` yang dipilih belum lengkap. Validasi ini dilakukan di `BagiHasilController` sebelum kalkulasi dimulai.

---

### 3.10 Tabel `laporan_operasional` (Model: `LaporanOperasional`)
```
id                  : INT (PK, Auto Increment)
musim_tanam         : STRING
status_finalisasi   : BOOLEAN (false = draft, true = final)
```
**Dependency:** Laporan bergantung pada `PembagianHasil`. Pastikan data bagi hasil sudah ada sebelum laporan dapat difinalisasi.

> ⚠️ Arah ketergantungan: `PembagianHasil → LaporanOperasional`, bukan sebaliknya.

---

## 4. RINGKASAN RELASI ANTAR TABEL

```
Pengguna        (1) ──── (0..*) AlokasiBibit        [Mengelola]
Pengguna        (1) ──── (0..*) DataPanen            [Mencatat]
Pengguna        (1) ──── (0..*) Transaksi            [Memproses]
Pengguna        (1) ──── (0..*) ArusKas              [Mencatat Keuangan]
Pengguna        (1) ──── (0..*) LaporanOperasional   [Membuat/Menyetujui]

Pelanggan       (1) ──── (0..*) Transaksi            [Melakukan]

AnggotaPetani   (1) ──── (0..*) AlokasiBibit         [Memiliki]
AnggotaPetani   (1) ──── (0..*) DataPanen            [Menyetorkan]
AnggotaPetani   (1) ──── (0..*) PembagianHasil       [Mendapatkan]

StokBeras       (1) ──── (0..*) Transaksi            [Berkurang Oleh]

DataPanen       (0..*) ──> (1)  PembagianHasil       [Dasar Kalkulasi]
ArusKas         (0..*) ──> (1)  PembagianHasil       [Dasar Kalkulasi]
PembagianHasil  (1)   ──> (1)  LaporanOperasional   [Komponen Laporan]
```

---

## 5. ALUR PROSES PER USE CASE

### UC-1: Autentikasi
- Input: `username`, `password`
- Proses: Query `tabel_pengguna` → verifikasi hash password → set sesi dengan `id_pengguna` dan `role`
- Output: Redirect ke dasbor sesuai `role`
- Gagal: Tampilkan pesan error, jangan redirect

### UC-2: Pengelolaan Data Pertanian dan Bibit
- Input: Data lahan petani + jumlah bibit
- Proses: Validasi form → Insert ke `anggota_petani` → ambil ID baru → Insert ke `alokasi_bibit`
- Output: Notifikasi berhasil
- Gagal: Tandai kolom yang kosong

### UC-3: Pemantauan Informasi Cuaca
- Input: Koordinat lokasi lahan kelompok tani
- Proses: `CuacaController` → `fetchPrakiraanCuaca(koordinat)` ke API eksternal → parsing JSON response
- Output: Tampilkan data cuaca dengan visualisasi
- Gagal: Tampilkan pesan error + tombol "Muat Ulang"
- **Catatan:** Data cuaca TIDAK disimpan ke database. Ini adalah data real-time dari API eksternal.

### UC-4: Pengelolaan Data Panen
- Input: Total panen per petani
- Proses: Tampilkan referensi data bibit → validasi batas toleransi → Insert ke `data_panen`
- Output: Notifikasi berhasil
- Gagal (anomali): Tampilkan konfirmasi "Apakah data sudah benar?" sebelum disimpan

### UC-5: Proses Transaksi dan Stok Beras
- **Fase 1 (Pelanggan):**
  - Input: Pilih produk + jumlah pesanan
  - Proses: Cek stok → jika cukup, Insert transaksi `status='Menunggu'` + kurangi stok sementara
  - Gagal: Tampilkan peringatan stok tidak cukup
- **Fase 2 (Staf Penjualan):**
  - Input: Pilih pesanan yang menunggu → klik Konfirmasi
  - Proses: Update `status='Selesai'` + update stok permanen
  - Output: Notifikasi konfirmasi berhasil

### UC-6: Pembuatan Arus Kas Keuangan
- Input: Jenis transaksi (pemasukan/pengeluaran), nominal, keterangan
- Proses: Validasi nominal > 0 dan tidak kosong → Insert ke `arus_kas` → update total saldo
- Output: Notifikasi + saldo diperbarui
- Gagal: Tandai kolom nominal yang tidak valid

### UC-7: Pembagian Hasil
- Input: Pilih musim tanam
- Proses:
  1. Cek kelengkapan data `arus_kas` untuk musim tersebut
  2. Jika lengkap: ambil `total_kas` + `proporsi_panen` per petani
  3. Hitung `alokasi_keuntungan` per petani secara otomatis
  4. Tampilkan pratinjau → staf konfirmasi → Insert batch ke `pembagian_hasil`
- Gagal: Blokir kalkulasi + tampilkan peringatan data kas belum lengkap

### UC-8: Pembuatan Laporan Operasional
- **Fase 1 (Staf Keuangan):**
  - Proses: Cek kelengkapan komponen (panen, kas, bagi hasil) → integrasikan data → tampilkan pratinjau → Finalisasi → update `status_finalisasi = true` + kirim notifikasi ke Ketua
- **Fase 2 (Ketua):**
  - Proses: Buka notifikasi → tampilkan laporan final → Cetak → generate PDF

### UC-9: Hak Akses Pengguna
- Input: Data pengguna baru (termasuk `username` dan `role`)
- Proses: Cek duplikasi `username` → hash password → Insert ke `pengguna`
- Output: Akun baru aktif dengan role yang ditetapkan
- Gagal: Tampilkan peringatan username sudah terdaftar

---

## 6. KEPUTUSAN TEKNIS YANG SUDAH DIKUNCI

| Topik | Keputusan |
|---|---|
| Identifier login | Gunakan `username` (bukan NIK) |
| Nama tabel keuangan | `arus_kas` (bukan `biaya_operasional`) |
| Tipe data bagi hasil | Kolom terpisah (`proporsi_panen`, `alokasi_keuntungan`), bukan JSON |
| Arah dependency laporan | `PembagianHasil` → `LaporanOperasional` |
| Data cuaca | Tidak disimpan ke DB, real-time dari API eksternal |
| Status transaksi | Enum: `'Menunggu'`, `'Selesai'`, `'Dibatalkan'` |
| Status laporan | Boolean: `false` = draft, `true` = final |
| Password storage | Wajib di-hash (bcrypt atau sejenisnya) |
| Stok saat pesanan masuk | Dikurangi sementara dulu, permanen setelah dikonfirmasi staf |

---

## 7. CATATAN PENTING UNTUK DEVELOPMENT

1. **RBAC wajib diterapkan di setiap route/endpoint.** Setiap controller harus memverifikasi `role` dari sesi aktif sebelum mengizinkan akses.
2. **Validasi dilakukan di Controller, bukan hanya di UI.** Semua validasi yang ada di sequence diagram harus ada pasangannya di sisi server.
3. **Urutan pengisian data mengikuti dependency berikut:**
   ```
   Data Pertanian & Bibit
         ↓
   Data Panen
         ↓
   Arus Kas Keuangan
         ↓
   Pembagian Hasil
         ↓
   Laporan Operasional
   ```
4. **Transaksi memiliki dua aktor berbeda di dua UI berbeda.** Pelanggan menggunakan halaman katalog (front-end publik), Staf Penjualan menggunakan dasbor internal. Pastikan routing dipisahkan.
5. **Laporan Operasional mengintegrasikan data dari seluruh tabel.** Query `generateLaporan()` akan berat — pertimbangkan eager loading atau query yang dioptimalkan.
