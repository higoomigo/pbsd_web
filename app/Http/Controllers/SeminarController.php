<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeminarController extends Controller
{
    /**
     * Display a listing of seminars for guests.
     */
    public function index(Request $request)
    {
        $query = Seminar::query()->where('is_published', true);

        // Filter berdasarkan tipe
        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan format
        if ($request->has('format') && $request->format != '') {
            $query->where('format', $request->format);
        }

        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date') && 
            $request->start_date != '' && $request->end_date != '') {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pembicara', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%")
                  ->orWhere('topik', 'like', "%{$search}%");
            });
        }

        // Sorting: upcoming first, then featured
        if ($request->has('sort')) {
            if ($request->sort == 'upcoming') {
                $query->orderBy('tanggal', 'asc')
                      ->orderBy('waktu_mulai', 'asc');
            } elseif ($request->sort == 'featured') {
                $query->where('is_featured', true)
                      ->orderBy('tanggal', 'asc');
            }
        } else {
            // Default: upcoming seminars first, then by date
            $query->orderBy('tanggal', 'asc')
                  ->orderBy('waktu_mulai', 'asc');
        }

        // Exclude cancelled seminars
        $query->where('is_cancelled', false);

        $seminars = $query->paginate(9);
        $tipeOptions = Seminar::getTipeOptions();
        $formatOptions = Seminar::getFormatOptions();

        return view('guest.seminar.index', compact(
            'seminars',
            'tipeOptions',
            'formatOptions'
        ));
    }

    /**
     * Display the specified seminar for guests.
     */
    public function show($slug)
    {
        $seminar = Seminar::where('slug', $slug)
                         ->where('is_published', true)
                         ->where('is_cancelled', false)
                         ->firstOrFail();

        // Get related seminars
        $relatedSeminars = Seminar::where('is_published', true)
                                 ->where('is_cancelled', false)
                                 ->where('id', '!=', $seminar->id)
                                 ->where(function($query) use ($seminar) {
                                     $query->where('tipe', $seminar->tipe)
                                           ->orWhere('format', $seminar->format)
                                           ->orWhere('topik', 'like', "%{$seminar->topik}%");
                                 })
                                 ->limit(3)
                                 ->get();

        return view('guest.seminar.show', compact('seminar', 'relatedSeminars'));
    }
}