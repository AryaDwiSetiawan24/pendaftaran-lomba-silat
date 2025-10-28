<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Models\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mulai query dengan eager loading count peserta
        $query = Competition::withCount('participants');

        // Jika ada pencarian, filter berdasarkan nama
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Ambil data, urutkan dari terbaru, dan paginasi (10 per halaman)
        $competitions = $query->latest()->paginate(10);

        return view('pages.admin.lomba', compact('competitions', 'search'));
    }

    public function create()
    {
        return view('pages.admin.lomba.add-lomba');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'competition_date' => 'nullable|date',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after:registration_start_date',
            'status' => 'required|in:akan_datang,dibuka,ditutup,selesai',
            'competition_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // <== validasi tambahan
        ], [
            'name.required' => 'Nama lomba wajib diisi.',
            'registration_end_date.after' => 'Tanggal akhir harus setelah tanggal mulai.',
            'competition_logo.image' => 'File logo harus berupa gambar.',
            'competition_logo.mimes' => 'Format logo harus jpg, jpeg, atau png.',
            'competition_logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        // Inisialisasi path logo
        $logoPath = null;

        // Jika ada file diunggah
        if ($request->hasFile('competition_logo')) {
            // Simpan ke storage/app/public/competition_logos
            $logoPath = $request->file('competition_logo')->store('competition_logos', 'public');
        }

        // Simpan ke database
        Competition::create([
            'name' => $request->name,
            'description' => $request->description,
            'competition_date' => $request->competition_date,
            'registration_start_date' => $request->registration_start_date,
            'registration_end_date' => $request->registration_end_date,
            'status' => $request->status,
            'competition_logo' => $logoPath, // <== simpan path logo
        ]);

        return redirect()->route('admin.lomba')->with('success', 'Lomba berhasil ditambahkan!');
    }

    // menampilkan detail lomba
    public function show($id)
    {
        $competition = Competition::findOrFail($id);
        $competition = Competition::withCount('participants')->findOrFail($id);
        return view('pages.admin.lomba.show', compact('competition'));
    }

    public function edit($id)
    {
        $competition = Competition::findOrFail($id);
        return view('pages.admin.lomba.edit', compact('competition'));
    }

    public function update(Request $request, $id)
    {
        $competition = Competition::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'competition_date' => 'required|date',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after:registration_start_date',
            'status' => 'required|in:akan_datang,dibuka,ditutup,selesai',
            'competition_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('competition_logo')) {
            // hapus logo lama jika ada
            if ($competition->competition_logo && Storage::disk('public')->exists($competition->competition_logo)) {
                Storage::disk('public')->delete($competition->competition_logo);
            }

            // simpan logo baru
            $competition->competition_logo = $request->file('competition_logo')->store('competition_logos', 'public');
        }

        // update data lainnya
        $competition->update($request->except('competition_logo'));

        return redirect()->route('admin.lomba')->with('success', 'Lomba berhasil diperbarui!');
    }

    // menghapus lomba
    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();

        return redirect()->route('admin.lomba')
            ->with('success', 'Lomba berhasil dihapus.');
    }

    // mengubah visibilitas jadwal lomba
    public function toggleVisibility($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->visible_schedule = !$competition->visible_schedule;
        $competition->save();

        return back()->with('success', 'Visibilitas jadwal berhasil diperbarui.');
    }
}
