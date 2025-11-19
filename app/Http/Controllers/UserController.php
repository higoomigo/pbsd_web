<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pages;
use App\Models\Mitra;
use App\Models\VisiMisi;
use App\Models\Berita;

class UserController extends Controller
{

    #1 LAnfinng LAKjtou
    public function welcome()
    {
        // $berita = Berita::all();
        // 3 terbaru yang status 'Terbit' (atau published_at != null)
        $beritaTerbaru = Berita::query()
            ->take(3)
            ->get(['id','judul','slug','ringkasan','thumbnail_path','published_at','author_id','kategori']);
        $mitra = Mitra::all();
        return view('welcome', compact('mitra', 'beritaTerbaru'));
    }   
    // Landing Routes
    public function profilFull()
    {
        return view('profil.profil_full');
    }

    //---------------------------------//
    // ====== Dropdown PROFILES ====== //
    public function about()
    {
        return view('guest.profil.about');
    }

    public function visiMisi()
    {
        $visimisi = VisiMisi::firstOrCreate(['id' => 1], ['visi' => null, 'misi' => []]);
        return view('guest.profil.visi_misi', compact('visimisi'));
    }

    public function strukturOrganisasi()
    {
        return view('guest.profil.struktur_organisasi');
    }

    public function roadmapAsta()
    {
        return view('guest.profil.roadmap');
    }

    public function kebijakan()
    {
        return view('guest.profil.kebijakan');
    }

    public function mitra()
    {
        return view('guest.profil.mitra');
    }

    //---------------------------------//
    // ====== Dropdown AKADEMIK ====== //
    public function publikasi()
    {
        return view('guest.akademik.publikasi');
    }
    public function media()
    {
        return view('guest.publikasi.media');
    }
    // public function jurnal()
    // {
    //     return view('guest.akademik.jurnal');
    // }
    // public function kegiatanIlmiah()
    // {
    //     return view('guest.akademik.kegiatan_ilmiah');
    // }
    // public function internationalVisit()
    // {
    //     return view('guest.akademik.international_visit');
    // }
    public function profilPeneliti()
    {
        return view('guest.akademik.profil_peneliti');
    }
    // public function lulusanS3()
    // {
    //     return view('guest.akademik.lulusan_s3');
    // }

    //--------------------------//
    // Dropdown KOMERSIALISASI //
    public function produkInovasi()
    {
        return view('guest.komersialisasi.produk_inovasi');
    }

    public function patenHki()
    {
        return view('guest.komersialisasi.paten_hki');
    }

    public function kerjaSamaRiset()
    {
        return view('guest.komersialisasi.kerja_sama_riset');
    }

    public function kontrakNonRiset()
    {
        return view('guest.komersialisasi.kontrak_non_riset');
    }

    public function umkmBinaan()
    {
        return view('guest.komersialisasi.umkm_binaan');
    }

    public function unitBisnisdanLayanan()
    {
        return view('guest.komersialisasi.unit_bisnis_dan_layanan');
    }

    //--------------------------//
    // Dropdown FASILITAS Route //
    public function fasilitasRiset(){
        return view('guest.fasilitas.fasilitas_riset');
    }

    public function sopProsedur(){
        return view('guest.fasilitas.sop_prosedur');
    }

    public function programMagang(){
        return view('guest.fasilitas.program_magang');
    }

    public function capacityBuilding(){
        return view('guest.fasilitas.capacity_building');
    }

    public function bookingFasilitas(){
        return view('guest.fasilitas.booking_fasilitas');
    }

    // public function timPeneliti()
    // {
    //     return view('profil.tim__peneliti');
    // }

    // public function kontak()
    // {
    //     return view('user.kontak');
    // }

    public function berita()
    {
        return view('news.show');
    }
    

    
}
