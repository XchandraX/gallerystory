<?php

namespace App\Http\Controllers;

use App\Models\foto;
use Illuminate\Http\Request;

class PrivateGalleryController extends Controller
{
    /**
     * Tampilkan form password
     */
    public function showForm()
    {
        // Jika sudah punya session, langsung redirect ke gallery
        if (session()->has('private_access')) {
            return redirect()->route('private.gallery');
        }
        
        return view('private-password');
    }

    /**
     * Verifikasi password
     */
    public function verify(Request $request)
    {
        $password = $request->input('password');
        
        // Ganti dengan password yang Anda inginkan
        $validPassword = config('gallery.private_password', 'admin123');
        
        if ($password === $validPassword) {
            session(['private_access' => true]);
            return redirect()->route('private.gallery');
        }
        
        return back()->withErrors(['password' => 'Password salah']);
    }

    /**
     * Tampilkan gallery private (hanya jika punya akses)
     */
    public function gallery(Request $request)
    {
        // CEK SESSION
        if (!session()->has('private_access')) {
            return redirect()->route('private.form')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil foto private dengan sorting
        $query = foto::where('is_private', 'private');
        
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $photos = $query->paginate(12);

        // Untuk request AJAX (load more)
        if ($request->wantsJson()) {
            return response()->json([
                'photos' => $photos->map(fn ($p) => [
                    'title' => $p->title,
                    'image_url' => $p->image,
                ]),
                'next_page' => $photos->currentPage() + 1,
                'has_more' => $photos->hasMorePages(),
            ]);
        }

        return view('private-gallery', compact('photos', 'sort'));
    }

    /**
     * Logout dari private gallery
     */
    public function logout(Request $request)
    {
        // Hapus session private
        $request->session()->forget('private_access');
        
        return redirect()->route('private.form')
            ->with('success', 'Berhasil keluar dari private gallery');
    }
}