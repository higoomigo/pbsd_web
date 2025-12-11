<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CollaborationController extends Controller
{
    /**
     * Menyimpan data kolaborasi baru dan mengirim notifikasi WhatsApp
     */
    public function store(Request $request)
    {
        Log::info('🚀 === FORM COLLABORATION SUBMISSION START ===');
        
        // 1. VALIDASI DATA
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'institution' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'collaboration_type' => 'required|in:Penelitian Bersama,Konsultasi Akademik,Kemitraan Industri,Program Magang,Lainnya',
            'message' => 'required|string|max:1000'
        ]);
        
        Log::info('✅ Data validated:', $validated);
        
        // 2. SIMPAN KE DATABASE
        $collaboration = Collaboration::create($validated);
        Log::info('💾 Data saved to database:', [
            'id' => $collaboration->id,
            'email' => $collaboration->email
        ]);
        
        // 3. KIRIM NOTIFIKASI WHATSAPP
        $notificationResult = $this->sendWhatsAppNotification($collaboration);
        Log::info('📱 Notification result:', $notificationResult);
        
        // 4. RESPONSE KE CLIENT
        return response()->json([
            'success' => true,
            'message' => 'Proposal kolaborasi berhasil dikirim!',
            'data' => [
                'id' => $collaboration->id,
                'name' => $collaboration->name,
                'email' => $collaboration->email,
            ],
            'notification_sent' => $notificationResult['success'] ?? false,
            'notification_message' => $notificationResult['success'] 
                ? 'Notifikasi WhatsApp terkirim' 
                : 'Notifikasi WhatsApp gagal dikirim'
        ], 201);
    }
    
    /**
     * Mengirim notifikasi WhatsApp via Fonnte API
     */
    private function sendWhatsAppNotification(Collaboration $collaboration): array
    {
        Log::info('📨 === SENDING WHATSAPP NOTIFICATION ===');
        
        // Ambil konfigurasi dari .env
        $apiKey = env('FONNTE_API_KEY');
        $adminPhone = env('ADMIN_PHONE_NUMBER');
        
        // Validasi konfigurasi
        if (empty($apiKey) || empty($adminPhone)) {
            Log::error('❌ Missing configuration:', [
                'api_key_empty' => empty($apiKey),
                'admin_phone_empty' => empty($adminPhone)
            ]);
            return ['success' => false, 'error' => 'Configuration missing'];
        }
        
        // Log preview (aman untuk security)
        Log::info('🔧 Configuration check:', [
            'api_key_length' => strlen($apiKey),
            'api_key_preview' => substr($apiKey, 0, 10) . '...',
            'admin_phone_raw' => $adminPhone
        ]);
        
        // Format nomor telepon
        $formattedPhone = $this->formatPhoneNumber($adminPhone);
        Log::info('📞 Formatted phone:', ['phone' => $formattedPhone]);
        
        // Buat pesan notifikasi SEDERHANA
        $message = $this->createSimpleNotificationMessage($collaboration);
        Log::info('💬 Message prepared:', [
            'length' => strlen($message),
            'preview' => substr($message, 0, 100)
        ]);
        
        // Kirim ke API Fonnte
        $result = $this->sendToFonnteApi($apiKey, $formattedPhone, $message);
        
        return $result;
    }
    
    /**
     * Format nomor telepon ke format internasional (62...)
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika diawali 0, ganti dengan 62
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }
        
        // Pastikan diawali 62 (untuk Indonesia)
        if (strpos($phone, '62') !== 0) {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }
    
    /**
     * Buat pesan notifikasi yang SANGAT SEDERHANA
     * Tanpa emoji, tanpa formatting kompleks
     */
    private function createSimpleNotificationMessage(Collaboration $collaboration): string
    {
        // Data dengan fallback jika null
        $name = $collaboration->name ?? 'Tidak diisi';
        $institution = $collaboration->institution ?? 'Tidak diisi';
        $email = $collaboration->email ?? 'Tidak diisi';
        $collabType = $collaboration->collaboration_type ?? 'Tidak diisi';
        $userMessage = $collaboration->message ?? 'Tidak ada pesan';
        $timestamp = $collaboration->created_at 
            ? $collaboration->created_at->format('d/m/Y H:i') 
            : now()->format('d/m/Y H:i');
        
        // Bersihkan pesan dari karakter bermasalah
        $userMessage = $this->cleanText($userMessage);
        
        // Format pesan SEDERHANA (tanpa emoji, tanpa markdown)
        $message = "PROPOSAL KOLABORASI BARU\n\n";
        $message .= "Nama: {$name}\n";
        $message .= "Institusi: {$institution}\n";
        $message .= "Email: {$email}\n";
        $message .= "Jenis Kolaborasi: {$collabType}\n\n";
        $message .= "Pesan:\n{$userMessage}\n\n";
        $message .= "Dikirim: {$timestamp}\n\n";
        $message .= "Segera ditanggapi!";
        
        // Potong jika terlalu panjang
        if (strlen($message) > 1000) {
            $message = substr($message, 0, 1000) . '... [pesan dipotong]';
        }
        
        return $message;
    }
    
    /**
     * Bersihkan teks dari karakter yang bermasalah
     */
    private function cleanText(string $text): string
    {
        // 1. Hapus karakter kontrol
        $text = preg_replace('/[\x00-\x1F\x7F]/', ' ', $text);
        
        // 2. Hapus tag HTML jika ada
        $text = strip_tags($text);
        
        // 3. Ganti multiple spaces/newlines dengan single space
        $text = preg_replace('/\s+/', ' ', $text);
        
        // 4. Trim
        $text = trim($text);
        
        // 5. Jika kosong setelah dibersihkan
        if (empty($text)) {
            $text = '[Pesan kosong]';
        }
        
        return $text;
    }
    
    /**
     * Kirim pesan ke API Fonnte dengan payload SEDERHANA
     */
    private function sendToFonnteApi(string $apiKey, string $phone, string $message): array
    {
        Log::info('🌐 === SENDING TO FONNTE API ===');
        
        // PAYLOAD SANGAT SEDERHANA - seperti yang berhasil di tinker
        $payload = [
            'target' => $phone,
            'message' => $message,
            // 'delay' => 2, // Optional, bisa di-uncomment jika perlu
        ];
        
        Log::info('📤 Payload to send:', $payload);
        
        try {
            // Gunakan Http Facade dengan timeout
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(30)->post('https://api.fonnte.com/send', $payload);
            
            $statusCode = $response->status();
            $responseData = $response->json() ?? [];
            
            Log::info('📥 API Response:', [
                'status_code' => $statusCode,
                'response' => $responseData
            ]);
            
            // Cek jika berhasil
            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
                Log::info('✅ Notification sent successfully!');
                return [
                    'success' => true,
                    'message' => 'Notification sent successfully',
                    'data' => $responseData,
                    'message_id' => $responseData['id'][0] ?? null
                ];
            } else {
                Log::warning('API error but NOT sending fallback:', $responseData);
                return [
                    'success' => false,
                    'error' => 'API error',
                    'details' => $responseData
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('❌ Fonnte API Exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return [
                'success' => false,
                'error' => 'API Exception: ' . $e->getMessage(),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];
        }
    }
    
    /**
     * Fallback method jika pengiriman pertama gagal
     */
    
    
    /**
     * ==================== METHOD UNTUK TESTING ====================
     */
    
    /**
     * Endpoint untuk testing manual notifikasi
     */
    public function testNotification()
    {
        Log::info('🧪 === MANUAL NOTIFICATION TEST ===');
        
        // Buat data dummy
        $dummyData = [
            'name' => 'John Doe (Test)',
            'institution' => 'Test University',
            'email' => 'test@example.com',
            'collaboration_type' => 'Penelitian Bersama',
            'message' => 'Ini adalah pesan testing untuk notifikasi WhatsApp.',
            'created_at' => now(),
        ];
        
        // Buat instance model
        $collaboration = new Collaboration($dummyData);
        
        // Panggil method notifikasi
        $result = $this->sendWhatsAppNotification($collaboration);
        
        return response()->json([
            'success' => true,
            'message' => 'Test notification executed',
            'test_result' => $result,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'config' => [
                'api_key_preview' => substr(env('FONNTE_API_KEY'), 0, 10) . '...',
                'admin_phone' => env('ADMIN_PHONE_NUMBER'),
            ]
        ]);
    }
    
    /**
     * Endpoint untuk test API Fonnte langsung
     */
    public function testFonnteDirect()
    {
        Log::info('🔧 === DIRECT FONNTE API TEST ===');
        
        $apiKey = env('FONNTE_API_KEY');
        $phone = env('ADMIN_PHONE_NUMBER');
        
        // Format phone
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }
        
        // Test dengan payload SANGAT sederhana
        $payload = [
            'target' => $phone,
            'message' => 'Test langsung dari controller',
        ];
        
        try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.fonnte.com/send', $payload);
            
            $result = [
                'status' => $response->status(),
                'response' => $response->json(),
                'payload_sent' => $payload,
                'config' => [
                    'api_key_length' => strlen($apiKey),
                    'target_phone' => $phone,
                ]
            ];
            
            Log::info('Direct test result:', $result);
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            Log::error('Direct test error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Endpoint untuk melihat data kolaborasi (debug)
     */
    public function listCollaborations()
    {
        $collaborations = Collaboration::latest()->take(10)->get();
        
        return response()->json([
            'total' => $collaborations->count(),
            'data' => $collaborations,
            'latest_id' => $collaborations->first()->id ?? null
        ]);
    }
}