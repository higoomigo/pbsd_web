<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaborationContactController extends Controller
{
    /**
     * Display a listing of collaboration contacts.
     */
    public function index()
    {
        $collaborations = Collaboration::latest()->paginate(10);
        
        return view('admin.collaborations.index', compact('collaborations'));
    }

    /**
     * Display the specified collaboration contact.
     */
    public function show(Collaboration $collaboration)
    {
        return view('admin.collaborations.show', compact('collaboration'));
    }

    /**
     * Remove the specified collaboration contact from storage.
     */
    public function destroy(Collaboration $collaboration)
    {
        $collaboration->delete();
        
        return redirect()->route('admin.kontak.index')
            ->with('success', 'Data kolaborasi berhasil dihapus.');
    }

    /**
     * Export collaborations to CSV
     */
    public function exportCSV()
    {
        $collaborations = Collaboration::latest()->get();
        
        $csvHeader = [
            'ID',
            'Nama Lengkap',
            'Institusi',
            'Email',
            'Jenis Kolaborasi',
            'Pesan',
            'Tanggal Dikirim',
            'Tanggal Diperbarui'
        ];
        
        $csvData = [];
        foreach ($collaborations as $collaboration) {
            $csvData[] = [
                $collaboration->id,
                $collaboration->name,
                $collaboration->institution,
                $collaboration->email,
                $collaboration->collaboration_type,
                $collaboration->message,
                $collaboration->created_at->format('d/m/Y H:i'),
                $collaboration->updated_at->format('d/m/Y H:i'),
            ];
        }
        
        $filename = 'kolaborasi_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($csvHeader, $csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Mark as read/unread
     */
    public function markAsRead(Collaboration $collaboration)
    {
        // Jika Anda ingin menambahkan status "read"
        // $collaboration->update(['read_at' => now()]);
        
        return back()->with('success', 'Ditandai sebagai sudah dibaca.');
    }
}