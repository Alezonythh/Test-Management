<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Cek apakah akun dibekukan
        $lockoutTime = Cache::get('lockout_' . $request->email);
        
        if ($lockoutTime && now()->lt($lockoutTime)) {
            // Membulatkan sisa waktu ke angka bulat terdekat
            $remainingTime = floor($lockoutTime->diffInSeconds(now()));
            
            throw ValidationException::withMessages([
                'email' => ["Akun Anda dibekukan, coba lagi dalam {$remainingTime} detik."],
            ]);
        }
    
        // Cek apakah login berhasil
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember-me'))) {
            // Jika autentikasi berhasil, regenerasi sesi
            $request->session()->regenerate();
            Cache::forget('failed_attempts_' . $request->email); // Hapus percobaan login yang gagal
    
            // Redirect ke halaman yang dituju setelah login berhasil
            return redirect()->intended(route('dashboard', absolute: false));
        }
    
        // Cek percobaan login yang gagal
        $failedAttempts = Cache::get('failed_attempts_' . $request->email, 0);
    
        if ($failedAttempts >= 3) {
            // Bekukan akun selama 30 detik jika gagal 3 kali
            Cache::put('lockout_' . $request->email, now()->addSeconds(30), 30);
            throw ValidationException::withMessages([
                'email' => ['Akun Anda dibekukan selama 30 detik karena percobaan login yang gagal.'],
            ]);
        }
    
        // Jika login gagal, tambahkan percobaan gagal ke cache
        Cache::put('failed_attempts_' . $request->email, $failedAttempts + 1, now()->addMinutes(1));
    
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout pengguna
        Auth::guard('web')->logout();

        // Invalidate session dan regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect('/');
    }
}
