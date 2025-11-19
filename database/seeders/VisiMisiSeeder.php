<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisiMisi;

class VisiMisiSeeder extends Seeder
{
    public function run(): void
    {
        $visi = 'Menjadi pusat unggulan dalam pelestarian, pengembangan, dan pemanfaatan bahasa dan sastra daerah sebagai warisan budaya yang mendukung identitas lokal dan kemajuan ilmu pengetahuan.';

        $misi = [
            'Mengembangkan dan melestarikan bahasa serta sastra daerah melalui penelitian, pengkajian, dan penerbitan karya ilmiah yang berkualitas.',
            'Mendorong penggunaan bahasa dan sastra daerah dalam berbagai aspek kehidupan masyarakat, termasuk pendidikan, seni, dan media.',
            'Melaksanakan penelitian dan pengkajian tentang bahasa dan sastra daerah di Gorontalo dan wilayah Nusantara untuk mendukung pelestarian dan pengembangan kebudayaan lokal.',
            'Mendokumentasikan dan mengarsipkan bahasa serta karya sastra daerah melalui media cetak dan digital guna menjamin keberlanjutan pengetahuan lintas generasi.',
            'Melakukan diseminasi dan edukasi publik melalui pelatihan, seminar, lokakarya, dan penerbitan yang mendorong pemanfaatan bahasa dan sastra daerah dalam kehidupan sehari-hari.',
            'Bersinergi dengan lembaga pemerintah, adat, dan komunitas lokal dalam program pelestarian dan revitalisasi bahasa serta sastra daerah.',
            'Mendukung kurikulum pendidikan lokal dengan menyediakan bahan ajar dan sumber literasi yang berbasis bahasa dan sastra daerah.',
        ];

        // Pastikan cuma satu baris: update kalau ada, buat kalau belum ada
        // VisiMisi::query()->updateOrCreate(
        //     ['id' => 1],
        //     ['visi' => $visi, 'misi' => $misi]
        // );
    }
}

