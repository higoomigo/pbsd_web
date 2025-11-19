<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> 
            {{ __('Dashboard') }} 
        </h2> 
    </x-slot>
<div x-data="{range: '7d'}" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 py-6">
    <div>
      <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Dashboard Progres Website</h1>
      <p class="text-sm text-zinc-500">Ringkasan metrik, progres konten, performa, dan kesehatan sistem.</p>
    </div>

    <!-- Range selector -->
    <div class="join">
      <button :class="range==='24h' ? 'btn btn-primary join-item' : 'btn join-item'" @click="range='24h'">24 jam</button>
      <button :class="range==='7d' ? 'btn btn-primary join-item' : 'btn join-item'" @click="range='7d'">7 hari</button>
      <button :class="range==='30d' ? 'btn btn-primary join-item' : 'btn join-item'" @click="range='30d'">30 hari</button>
    </div>
  </div>

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @php
      $kpis = [
        ['label' => 'Kunjungan', 'value' => '12,430', 'delta' => '+8.2%', 'hint' => 'Total sesi'],
        ['label' => 'Pengguna Aktif', 'value' => '321', 'delta' => '+3.1%', 'hint' => 'Realtime (est.)'],
        ['label' => 'Bounce Rate', 'value' => '38%', 'delta' => '-1.4%', 'hint' => 'Semakin rendah semakin baik'],
        ['label' => 'Durasi Sesi', 'value' => '02:14', 'delta' => '+0:09', 'hint' => 'Rata-rata'],
      ];
    @endphp
    @foreach($kpis as $k)
      <div class="card bg-white shadow-sm">
        <div class="card-body p-4">
          <div class="text-sm text-zinc-500">{{ $k['label'] }}</div>
          <div class="mt-2 flex items-end justify-between">
            <div class="text-2xl font-semibold">{{ $k['value'] }}</div>
            <span class="badge {{ str_starts_with($k['delta'], '+') ? 'badge-success' : 'badge-error' }} badge-outline">{{ $k['delta'] }}</span>
          </div>
          <div class="mt-1 text-xs text-zinc-400">{{ $k['hint'] }}</div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Charts Row -->
  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Traffic Trend -->
    <div class="card bg-white shadow-sm lg:col-span-2">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h3 class="card-title text-base">Tren Trafik</h3>
          <div class="text-xs text-zinc-400">Sesi & Pengguna</div>
        </div>
        <div id="chart-traffic" class="mt-4 h-64 w-full rounded-xl bg-zinc-50 flex items-center justify-center">
          <span class="text-zinc-400 text-sm">(Area chart placeholder)</span>
        </div>
      </div>
    </div>

    <!-- Sumber Trafik -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-base">Sumber Trafik</h3>
        <div id="chart-sources" class="mt-4 h-64 w-full rounded-xl bg-zinc-50 flex items-center justify-center">
          <span class="text-zinc-400 text-sm">(Donut chart placeholder)</span>
        </div>
        <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
          <div class="flex items-center justify-between"><span>Organik</span><span class="font-medium">42%</span></div>
          <div class="flex items-center justify-between"><span>Langsung</span><span class="font-medium">31%</span></div>
          <div class="flex items-center justify-between"><span>Rujukan</span><span class="font-medium">17%</span></div>
          <div class="flex items-center justify-between"><span>Sosial</span><span class="font-medium">10%</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Geography & Top Pages -->
  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Geo Heatmap -->
    <div class="card bg-white shadow-sm lg:col-span-2">
      <div class="card-body">
        <h3 class="card-title text-base">Pengunjung per Negara</h3>
        <div id="map-heat" class="mt-4 h-72 w-full rounded-xl bg-zinc-50 flex items-center justify-center">
          <span class="text-zinc-400 text-sm">(World heatmap placeholder)</span>
        </div>
        <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
          <div class="flex items-center justify-between"><span>Indonesia</span><span class="font-medium">65%</span></div>
          <div class="flex items-center justify-between"><span>Malaysia</span><span class="font-medium">8%</span></div>
          <div class="flex items-center justify-between"><span>Singapura</span><span class="font-medium">6%</span></div>
          <div class="flex items-center justify-between"><span>US</span><span class="font-medium">5%</span></div>
        </div>
      </div>
    </div>

    <!-- Top Pages -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-base">Halaman Teratas</h3>
        <div class="mt-2 space-y-3">
          @php
            $pages = [
              ['/','Beranda','2,341'],
              ['/publikasi','Publikasi','1,211'],
              ['/event','Kegiatan','934'],
              ['/tentang','Tentang Kami','811'],
              ['/kontak','Kontak','421'],
            ];
          @endphp
          @foreach($pages as [$url,$title,$views])
            <a href="{{ $url }}" class="group flex items-center justify-between rounded-lg border border-zinc-100 p-3 hover:bg-zinc-50">
              <div class="min-w-0">
                <div class="truncate font-medium group-hover:underline">{{ $title }}</div>
                <div class="truncate text-xs text-zinc-500">{{ $url }}</div>
              </div>
              <div class="text-sm font-semibold">{{ $views }}</div>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Content Progress & Roadmap -->
  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Content Progress -->
    <div class="card bg-white shadow-sm lg:col-span-2">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h3 class="card-title text-base text-zinc-700">Progres Konten</h3>
          <a href="#" class="text-sm text-primary hover:underline">Kelola</a>
        </div>
        @php
          $content = [
            ['label'=>'Profil Lembaga','done'=>8,'total'=>10],
            ['label'=>'Struktur & SK','done'=>4,'total'=>6],
            ['label'=>'Publikasi (SINTA/Scopus)','done'=>27,'total'=>40],
            ['label'=>'Kegiatan & Galeri','done'=>12,'total'=>20],
            ['label'=>'Jurnal yang Dikelola','done'=>2,'total'=>4],
          ];
        @endphp
        <div class="mt-4 space-y-4">
          @foreach($content as $c)
            @php $pct = (int) round(($c['done']/$c['total'])*100); @endphp
            <div>
              <div class="flex items-center justify-between text-sm">
                <span>{{ $c['label'] }}</span>
                <span class="tabular-nums">{{ $c['done'] }}/{{ $c['total'] }} ({{ $pct }}%)</span>
              </div>
              <progress class="progress progress-primary w-full" value="{{ $pct }}" max="100"></progress>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Roadmap / Tasks -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h3 class="card-title text-base">Roadmap & Tugas</h3>
          <a href="#" class="text-sm text-primary hover:underline">Lihat semua</a>
        </div>
        @php
          $tasks = [
            ['title'=>'Implementasi RBAC untuk Kontributor','tag'=>'Backend','done'=>false],
            ['title'=>'Halaman Peta Riset (Leaflet)','tag'=>'Feature','done'=>true],
            ['title'=>'Impor Publikasi dari SINTA API','tag'=>'Data','done'=>false],
            ['title'=>'SEO meta & sitemap','tag'=>'SEO','done'=>false],
            ['title'=>'Integrasi Analytics GA4','tag'=>'Analytics','done'=>true],
          ];
        @endphp
        <ul class="mt-3 space-y-2">
          @foreach($tasks as $t)
            <li class="flex items-start gap-2">
              <input type="checkbox" class="checkbox checkbox-sm mt-0.5" {{ $t['done'] ? 'checked' : '' }} />
              <div class="flex-1">
                <div class="text-sm">{{ $t['title'] }}</div>
                <div class="text-xs text-zinc-500">{{ $t['tag'] }}</div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <!-- Health & Quality Row -->
  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Performance & Core Web Vitals -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-base">Performa (Core Web Vitals)</h3>
        <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
          <div class="rounded-xl border p-3">
            <div class="text-zinc-500">LCP</div>
            <div class="text-xl font-semibold">1.9s</div>
            <div class="text-xs text-zinc-400">Target ≤ 2.5s</div>
          </div>
          <div class="rounded-xl border p-3">
            <div class="text-zinc-500">INP</div>
            <div class="text-xl font-semibold">160ms</div>
            <div class="text-xs text-zinc-400">Target ≤ 200ms</div>
          </div>
          <div class="rounded-xl border p-3">
            <div class="text-zinc-500">CLS</div>
            <div class="text-xl font-semibold">0.04</div>
            <div class="text-xs text-zinc-400">Target ≤ 0.1</div>
          </div>
          <div class="rounded-xl border p-3">
            <div class="text-zinc-500">FCP</div>
            <div class="text-xl font-semibold">1.2s</div>
            <div class="text-xs text-zinc-400">Render awal</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Deploy & Uptime -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-base">Build, Deploy & Uptime</h3>
        <div class="mt-3 space-y-3 text-sm">
          <div class="flex items-center justify-between"><span>Last Deploy</span><span class="font-medium">2025-10-29 21:14</span></div>
          <div class="flex items-center justify-between"><span>Branch</span><span class="font-mono">main@e3f9c2a</span></div>
          <div class="flex items-center justify-between"><span>Environment</span><span class="badge badge-outline">production</span></div>
          <div class="flex items-center justify-between"><span>Uptime 7d</span><span class="font-medium">99.96%</span></div>
          <div class="flex items-center justify-between"><span>Queue</span><span class="font-medium">0 pending</span></div>
        </div>
      </div>
    </div>

    <!-- Errors & 404 -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h3 class="card-title text-base">Error & 404 Terbaru</h3>
          <a href="#" class="text-sm text-primary hover:underline">Log</a>
        </div>
        <ul class="mt-3 space-y-2 text-sm">
          <li class="rounded-lg border p-3"><span class="badge badge-error badge-outline mr-2">500</span> POST /api/publikasi — SQLSTATE[23000] (Integrity)</li>
          <li class="rounded-lg border p-3"><span class="badge badge-warning badge-outline mr-2">404</span> GET /jurnal/abc</li>
          <li class="rounded-lg border p-3"><span class="badge badge-warning badge-outline mr-2">403</span> GET /admin/users (unauthorized)</li>
          <li class="rounded-lg border p-3"><span class="badge badge-error badge-outline mr-2">500</span> GET /feed.xml — View not found</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- SEO & Feedback Row -->
  <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- SEO Checklist -->
    <div class="card bg-white shadow-sm">
      <div class="card-body">
        <h3 class="card-title text-base">SEO & Kualitas Konten</h3>
        <ul class="mt-3 space-y-2 text-sm">
          <li class="flex items-center gap-2"><span class="badge badge-success badge-xs"></span> Sitemap.xml tersedia</li>
          <li class="flex items-center gap-2"><span class="badge badge-success badge-xs"></span> Robots.txt ok</li>
          <li class="flex items-center gap-2"><span class="badge badge-warning badge-xs"></span> 12 halaman tanpa meta description</li>
          <li class="flex items-center gap-2"><span class="badge badge-warning badge-xs"></span> 5 gambar > 300KB (butuh kompres)</li>
          <li class="flex items-center gap-2"><span class="badge badge-error badge-xs"></span> 3 link putus</li>
        </ul>
      </div>
    </div>

    <!-- Feedback Pengguna -->
    <div class="card bg-white shadow-sm lg:col-span-2">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h3 class="card-title text-base">Feedback Pengguna</h3>
          <a href="#" class="text-sm text-primary hover:underline">Kelola</a>
        </div>
        <div class="mt-3 divide-y">
          @php
            $fb = [
              ['name'=>'Rizki','msg'=>'Tolong tambahkan filter tahun di halaman publikasi.','rating'=>4],
              ['name'=>'Sarah','msg'=>'Galeri kegiatan loadingnya agak lama.','rating'=>3],
              ['name'=>'Dani','msg'=>'Suka UI-nya, mudah cari data dosen.','rating'=>5],
            ];
          @endphp
          @foreach($fb as $f)
            <div class="py-3 flex items-start gap-3">
              <div class="avatar placeholder">
                <div class="w-8 rounded-full bg-zinc-200"></div>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <div class="font-medium">{{ $f['name'] }}</div>
                  <div class="text-xs text-zinc-500">{{ now()->subHours(rand(2,48))->diffForHumans() }}</div>
                </div>
                <p class="text-sm text-zinc-700">{{ $f['msg'] }}</p>
                <div class="mt-1 text-xs">Rating: {{ str_repeat('★',$f['rating']) }}{{ str_repeat('☆',5-$f['rating']) }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Notes -->
  <div class="mt-8 mb-12 text-xs text-zinc-400">
    <p>Catatan: Data di atas adalah placeholder. Hubungkan dengan sumber data Anda (GA4, database internal, Laravel Pulse, Telescope, uptime monitor, dsb.).</p>
  </div>
</div>
</x-app-layout>
