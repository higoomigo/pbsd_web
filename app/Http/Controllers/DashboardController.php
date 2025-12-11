<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Artikel;
use App\Models\Dokumen;
use App\Models\User;
use App\Models\Fasilitas;
use App\Models\PublikasiTerindeks;
use App\Models\Seminar;
use App\Models\Peneliti;
use App\Models\Mitra;
use App\Models\Komentar;
use App\Models\GaleriAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\WebsiteVisit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        // Get counts for dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Recent activities
        $recentActivities = $this->getRecentActivities();
        
        $visitModel = new WebsiteVisit();
        
        // 2. Hitung Total Kunjungan dan Kunjungan Unik
        $totalWebsiteVisits = $visitModel->visits()->count();
        // $uniqueVisits = $visitModel->visits()->unique()->count();

        // Recent news
        $recentBerita = Berita::latest()->take(5)->get(['id', 'judul', 'kategori', 'published_at', 'thumbnail_path']);
        
        // Upcoming seminars
        $upcomingSeminars = Seminar::where('tanggal', '>=', now()->format('Y-m-d'))
            ->where('is_published', true)
            ->where('is_cancelled', false)
            ->orderBy('tanggal')
            ->take(3)
            ->get(['id', 'judul', 'tanggal', 'waktu_mulai', 'tempat', 'format']);

        // Chart data - default monthly
        $chartData = $this->getMonthlyChartData();

        return view('dashboard', compact(
            'stats',
            'totalWebsiteVisits',
            // 'uniqueVisits', 
            'recentActivities',
            'recentBerita',
            'upcomingSeminars',
            'chartData'
        ));
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats()
    {
        return [
            'total_berita' => Berita::count(),
            'published_berita' => Berita::whereNotNull('published_at')
                ->where('published_at', '<=', now())->count(),
            'draft_berita' => Berita::whereNull('published_at')
                ->orWhere('published_at', '>', now())->count(),
            
            'total_artikel' => Artikel::count(),
            'published_artikel' => Artikel::whereNotNull('published_at')
                ->where('published_at', '<=', now())->count(),
            
            'total_dokumen' => Dokumen::count(),
            'total_albums' => GaleriAlbum::count(),
            'total_fasilitas' => Fasilitas::count(),
            'total_peneliti' => Peneliti::count(),
            'total_mitra' => Mitra::count(),
            'total_publikasi' => PublikasiTerindeks::count(),
            'total_seminar' => Seminar::count(),
            'pending_komentar' => Komentar::where('is_approved', 0)->count(),
            
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'editor_users' => User::where('role', 'editor')->count(),
        ];
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        $activities = collect();
        
        // Get recent berita (last 3)
        $recentBerita = Berita::latest()->take(3)->get()
            ->map(function($item) {
                return [
                    'type' => 'berita',
                    'title' => $item->judul,
                    'time' => $item->created_at,
                    'icon' => 'newspaper',
                    'color' => 'text-blue-600 bg-blue-100',
                    'url' => route('admin.publikasi-data.berita.edit', $item->id)
                ];
            });
        
        // Get recent artikel (last 2)
        $recentArtikel = Artikel::latest()->take(2)->get()
            ->map(function($item) {
                return [
                    'type' => 'artikel',
                    'title' => $item->judul,
                    'time' => $item->created_at,
                    'icon' => 'document-text',
                    'color' => 'text-green-600 bg-green-100',
                    'url' => route('admin.publikasi-data.artikel.edit', $item->id)
                ];
            });
        
        // Get recent seminars (last 2)
        $recentSeminars = Seminar::latest()->take(2)->get()
            ->map(function($item) {
                return [
                    'type' => 'seminar',
                    'title' => $item->judul,
                    'time' => $item->created_at,
                    'icon' => 'calendar',
                    'color' => 'text-red-600 bg-red-100',
                    'url' => route('admin.penelitian.seminar.edit', $item->id)
                ];
            });
        
        // Merge and sort all activities
        $activities = $activities->merge($recentBerita)
            ->merge($recentArtikel)
            ->merge($recentSeminars);
        
        return $activities->sortByDesc('time')->take(8)->values();
    }

    /**
     * Get monthly chart data
     */
    private function getMonthlyChartData()
    {
        $currentYear = date('Y');
        $months = [];
        $beritaData = [];
        $artikelData = [];
        $dokumenData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $months[] = Carbon::create()->month($i)->translatedFormat('M');
            
            // Count berita per month
            $beritaCount = Berita::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->count();
            $beritaData[] = $beritaCount;
            
            // Count artikel per month
            $artikelCount = Artikel::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->count();
            $artikelData[] = $artikelCount;
            
            // Count dokumen per month
            $dokumenCount = Dokumen::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->count();
            $dokumenData[] = $dokumenCount;
        }
        
        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Berita',
                    'data' => $beritaData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Artikel',
                    'data' => $artikelData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Dokumen',
                    'data' => $dokumenData,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    /**
     * Get weekly chart data
     */
    private function getWeeklyChartData()
    {
        $weeks = [];
        $beritaData = [];
        $artikelData = [];
        
        // Get data for last 8 weeks
        for ($i = 7; $i >= 0; $i--) {
            $startDate = now()->subWeeks($i)->startOfWeek();
            $endDate = now()->subWeeks($i)->endOfWeek();
            
            $weekLabel = 'Minggu ' . (8 - $i) . ' (' . $startDate->format('d M') . ')';
            $weeks[] = $weekLabel;
            
            // Count berita per week
            $beritaCount = Berita::whereBetween('created_at', [$startDate, $endDate])->count();
            $beritaData[] = $beritaCount;
            
            // Count artikel per week
            $artikelCount = Artikel::whereBetween('created_at', [$startDate, $endDate])->count();
            $artikelData[] = $artikelCount;
        }
        
        return [
            'labels' => $weeks,
            'datasets' => [
                [
                    'label' => 'Berita',
                    'data' => $beritaData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4
                ],
                [
                    'label' => 'Artikel',
                    'data' => $artikelData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    /**
     * API endpoint for chart data
     */
    public function chartData(Request $request)
    {
        $range = $request->get('range', 'monthly');
        
        if ($range === 'weekly') {
            $data = $this->getWeeklyChartData();
        } else {
            $data = $this->getMonthlyChartData();
        }
        
        return response()->json($data);
    }
}