  GET|HEAD        / ......................................................................................................................................  
  GET|HEAD        about ..................................................................................................... about › UserController@about  
  GET|HEAD        admin ..................................................................................................... admin › UserController@admin  
  GET|HEAD        admin/akademik .......................................................................... admin.akademik › AdminController@adminAkademik  
  GET|HEAD        admin/fasilitas ....................................................................... admin.fasilitas › AdminController@adminFasilitas  
  GET|HEAD        admin/komersialisasi ........................................................ admin.komersialisasi › AdminController@adminKomersialisasi  
  GET|HEAD        admin/kontak ................................................................................ admin.kontak › AdminController@adminKontak  
  GET|HEAD        admin/profil ................................................................................ admin.profil › AdminController@adminProfil  
  GET|HEAD        admin/profil/edit-visi-misi ............................................................... visimisi.edit › PagesController@editVisiMisi  
  PATCH           admin/profil/edit-visi-misi ........................................................... visimisi.update › PagesController@updateVisiMisi  
  GET|HEAD        admin/publikasi-data ......................................................... admin.publikasi-data › AdminController@adminPublikasiData  
  GET|HEAD        berita ..................................................................................... berita.index › Admin\BeritaController@index  
  POST            berita ..................................................................................... berita.store › Admin\BeritaController@store  
  GET|HEAD        berita-show ......................................................................................... beritashow › UserController@berita  
  GET|HEAD        berita/create ............................................................................ berita.create › Admin\BeritaController@create  
  GET|HEAD        berita/{beritum} ............................................................................. berita.show › Admin\BeritaController@show  
  PUT|PATCH       berita/{beritum} ......................................................................... berita.update › Admin\BeritaController@update  
  DELETE          berita/{beritum} ....................................................................... berita.destroy › Admin\BeritaController@destroy  
  GET|HEAD        berita/{beritum}/edit ........................................................................ berita.edit › Admin\BeritaController@edit  
  GET|HEAD        booking-fasilitas ............................................................................ booking › UserController@bookingFasilitas  
  GET|HEAD        capacity-building-workshop ......................................................... capacity-building › UserController@capacityBuilding  
  GET|HEAD        confirm-password ............................................................ password.confirm › Auth\ConfirmablePasswordController@show  
  POST            confirm-password .............................................................................. Auth\ConfirmablePasswordController@store  
  GET|HEAD        dashboard .................................................................................................................... dashboard  
  POST            email/verification-notification ................................. verification.send › Auth\EmailVerificationNotificationController@store  
  GET|HEAD        fasilitas-riset-lab .................................................................... fasilitas-riset › UserController@fasilitasRiset  
  GET|HEAD        forgot-password ............................................................. password.request › Auth\PasswordResetLinkController@create  
  POST            forgot-password ................................................................ password.email › Auth\PasswordResetLinkController@store  
  GET|HEAD        international-visit ............................................................ international-visit › UserController@internationalVisit  
  GET|HEAD        jurnal .................................................................................................. jurnal › UserController@jurnal  
  GET|HEAD        kebijakan-tata-kelola ............................................................................. kebijakan › UserController@kebijakan  
  GET|HEAD        kegiatan-ilmiah ........................................................................ kegiatan-ilmiah › UserController@kegiatanIlmiah  
  GET|HEAD        kerjasama-riset ........................................................................ kerjasama-riset › UserController@kerjasamaRiset  
  GET|HEAD        kontak .................................................................................................. kontak › UserController@kontak  
  GET|HEAD        kontrak-nonriset ..................................................................... kontrak-nonriset › UserController@kontrakNonRiset  
  GET|HEAD        login ............................................................................... login › Auth\AuthenticatedSessionController@create  
  POST            login ........................................................................................ Auth\AuthenticatedSessionController@store  
  POST            logout ............................................................................ logout › Auth\AuthenticatedSessionController@destroy  
  GET|HEAD        lulusan .......................................................................................... lulusan-s3 › UserController@lulusanS3  
  GET|HEAD        mitra-strategis ........................................................................................... mitra › UserController@mitra  
  PUT             password .............................................................................. password.update › Auth\PasswordController@update  
  GET|HEAD        paten-hki .......................................................................................... paten-hki › UserController@patenHki  
  GET|HEAD        produk-inovasi-pusat-studi ............................................................... produk-inovasi › UserController@produkInovasi  
  GET|HEAD        profil ......................................................................................... profil-full › UserController@profilFull  
  GET|HEAD        profil-peneliti ........................................................................ profil-peneliti › UserController@profilPeneliti  
  GET|HEAD        profile .......................................................................................... profile.edit › ProfileController@edit  
  PATCH           profile ...................................................................................... profile.update › ProfileController@update  
  DELETE          profile .................................................................................... profile.destroy › ProfileController@destroy  
  GET|HEAD        program-magang ................................................................................... magang › UserController@programMagang  
  GET|HEAD        publikasi ......................................................................................... publikasi › UserController@publikasi  
  GET|HEAD        register ............................................................................... register › Auth\RegisteredUserController@create  
  POST            register ........................................................................................... Auth\RegisteredUserController@store  
  POST            reset-password ....................................................................... password.store › Auth\NewPasswordController@store  
  GET|HEAD        reset-password/{token} .............................................................. password.reset › Auth\NewPasswordController@create  
  GET|HEAD        roadmap-asta-cita ............................................................................ roadmap-asta › UserController@roadmapAsta  
  GET|HEAD        sop-prosedur .......................................................................................... sop › UserController@sopProsedur  
  GET|HEAD        storage/{path} ........................................................................................................... storage.local
  GET|HEAD        struktur-organisasi ............................................................ struktur-organisasi › UserController@strukturOrganisasi  
  GET|HEAD        tim-peneliti ................................................................................. tim-peneliti › UserController@timPeneliti  
  GET|HEAD        umkm-binaan .................................................................................... umkm-binaan › UserController@umkmBinaan  
  GET|HEAD        unit-bisnis .......................................................................... unit-bisnis › UserController@unitBisnisDanLayanan  
  GET|HEAD        up .....................................................................................................................................  
  GET|HEAD        verify-email .............................................................. verification.notice › Auth\EmailVerificationPromptController  
  GET|HEAD        verify-email/{id}/{hash} .............................................................. verification.verify › Auth\VerifyEmailController  
  GET|HEAD        visi-misi .......................................................................................... visi-misi › UserController@visiMisi  
  GET|HEAD        visi_misi ............................................................................. visi_misi.index › Admin\VisiMisiController@index  
  POST            visi_misi ............................................................................. visi_misi.store › Admin\VisiMisiController@store  
  GET|HEAD        visi_misi/create .................................................................... visi_misi.create › Admin\VisiMisiController@create  
  GET|HEAD        visi_misi/{visi_misi} ................................................................... visi_misi.show › Admin\VisiMisiController@show  
  PUT|PATCH       visi_misi/{visi_misi} ............................................................... visi_misi.update › Admin\VisiMisiController@update  
  DELETE          visi_misi/{visi_misi} ............................................................. visi_misi.destroy › Admin\VisiMisiController@destroy  
  GET|HEAD        visi_misi/{visi_misi}/edit .............................................................. visi_misi.edit › Admin\VisiMisiController@edit