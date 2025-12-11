<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pages;
use App\Models\Mitra;
use App\Models\VisiMisi;
use App\Models\Berita;
use App\Models\Artikel;
use App\Models\Struktur;
use App\Models\GaleriAlbum;
use App\Models\Fasilitas;
use App\Models\WebsiteVisit;

class UserController extends Controller
{

    #1 LAnfinng LAKjtou
    public function welcome()
    {   

        $visitModel = new WebsiteVisit(); 
    
        // Catat kunjungan dengan menyertakan IP dan Session (paling disarankan)
        $visitModel->visit()->withIP()->withSession(); 
        // dd($visitModel);
        
        // Opsional: Jika Anda ingin menghitung kunjungan unik, 
        // Anda bisa memberikan kunci yang sama untuk semua kunjungan ke halaman ini.
        // $visitModel->visit('home')->withIP()->withSession();
        //  $fasilitas = Fasilitas::getUntukBeranda();
        // $berita = Berita::all();
        // 3 terbaru yang status 'Terbit' (atau published_at != null)
        // Ambil 2 album terbaru atau album yang ditandai featured
        $featuredAlbums = GaleriAlbum::published()
            ->where('tampil_beranda', true) // Jika ada field untuk featured
            ->orWhere(function($query) {
                $query->published()->latest('published_at');
            })
            ->withCount('media')
            ->limit(2)
            ->get();
        $artikelTerbitan = Artikel::with('author')
        ->latest('published_at')
        ->take(3)
        ->get(['id','judul','slug','ringkasan','penulis','author_id','kategori','published_at']);
        // dd($artikelTerbitan);  
        $beritaTerbaru = Berita::query()
            ->take(3)
            ->get(['id','judul','slug','ringkasan','thumbnail_path','published_at','author_id','kategori']);
        $mitra = Mitra::query()
            ->orderBy('urutan', 'asc')
            ->get();
        return view('welcome', compact('mitra', 'beritaTerbaru', 'artikelTerbitan', 'featuredAlbums'));
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
        // Ambil struktur terbaru (kalau cuma ada 1 record, tetap aman)
        $struktur = Struktur::query()
            ->orderByDesc('created_at')
            ->first();

        return view('guest.profil.struktur_organisasi', [
            'struktur'      => $struktur,
        ]);
        
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
    public function artikel()
    {

        return view('guest.publikasi.artikel');
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
    public function fasilitasIndex()
    {
        // Ambil fasilitas yang aktif, diurutkan berdasarkan urutan tampil
        $fasilitas = Fasilitas::where('tampil_beranda', true)
            ->orderBy('urutan_tampil', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guest.fasilitas.index', compact('fasilitas'));
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
