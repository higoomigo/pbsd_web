<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    // Landing Routes
    public function profilFull()
    {
        return view('profil.profil_full');
    }


    // ====== Dropdown Views
    public function about()
    {
        return view('profil.about');
    }

    public function visiMisi()
    {
        return view('profil.visi_misi');
    }

    public function strukturOrganisasi()
    {
        return view('profil.struktur_organisasi');
    }

    public function roadmapAsta()
    {
        return view('profil.roadmap');
    }

    public function kebijakan()
    {
        return view('profil.kebijakan');
    }

    public function mitra()
    {
        return view('profil.mitra');
    }

    public function timPeneliti()
    {
        return view('profil.tim__peneliti');
    }

    public function kontak()
    {
        return view('user.kontak');
    }

    public function berita()
    {
        return view('news.show');
    }
    

    
}
