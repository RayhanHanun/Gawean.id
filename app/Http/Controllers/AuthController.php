<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user by email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->withInput();
        }

        // Check password (plain text comparison since existing data uses plain text)
        if ($user->password !== $credentials['password']) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'hrd') {
            return redirect()->route('hrd.dashboard');
        } elseif ($user->role === 'pelamar') {
            return redirect()->route('pelamar.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => 'required|in:pelamar,hrd',
            // HRD specific fields
            'company_name' => 'required_if:role,hrd|max:100',
            'company_address' => 'required_if:role,hrd',
            // Pelamar specific fields
            'phone_number' => 'nullable|max:15',
        ]);

        $userId = User::generateId($request->role);

        $user = User::create([
            'id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Store as plain text to match existing data
            'role' => $request->role,
        ]);

        // Create profile for pelamar
        if ($request->role === 'pelamar') {
            Profile::create([
                'id' => Profile::generateId(),
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
            ]);
        }

        // Create company for HRD
        if ($request->role === 'hrd') {
            Company::create([
                'id' => Company::generateId(),
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'address' => $request->company_address,
                'description' => $request->company_description,
                'website' => $request->company_website,
                'status_verifikasi' => 'pending',
            ]);
        }

        Auth::login($user);

        return match($user->role) {
            'hrd' => redirect()->route('hrd.dashboard')->with('success', 'Registrasi berhasil! Akun perusahaan Anda sedang menunggu verifikasi admin.'),
            'pelamar' => redirect()->route('pelamar.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Gawean.id'),
            default => redirect()->route('home')
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil logout.');
    }
}
