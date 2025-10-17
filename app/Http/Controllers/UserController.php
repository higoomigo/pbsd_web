<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function visiMisi()
    {
        return view('profil.visi_misi');
    }

    public function strukturOrganisasi()
    {
        return view('user.struktur-organisasi');
    }

    public function timPeneliti()
    {
        return view('user.tim-peneliti');
    }

    public function kontak()
    {
        return view('user.kontak');
    }

    public function berita()
    {
        return view('user.berita');
    }
}
