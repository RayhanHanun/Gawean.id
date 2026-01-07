<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Profile;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelamarController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // 1. Mengambil Statistik Lamaran secara Real-time
        $query = Application::where('user_id', $user->id);

        $stats = [
            'total_applications' => (clone $query)->count(),
            'pending'   => (clone $query)->where('status', 'pending')->count(),
            'interview' => (clone $query)->where('status', 'interview')->count(),
            'accepted'  => (clone $query)->where('status', 'accepted')->count(),
            'rejected'  => (clone $query)->where('status', 'rejected')->count(),
        ];

        // 2. Mengambil 5 Riwayat Lamaran Terakhir
        // Menggunakan eager loading 'with' agar query efisien (mencegah N+1 problem)
        $recentApplications = Application::with(['job.company'])
            ->where('user_id', $user->id)
            ->orderBy('apply_date', 'desc')
            ->take(5)
            ->get();

        // 3. Fitur Rekomendasi Lowongan
        // Logika: Tampilkan lowongan aktif yang BELUM pernah dilamar oleh user ini
        $appliedJobIds = Application::where('user_id', $user->id)->pluck('job_id');

        $recommendedJobs = Job::active() // Menggunakan scopeActive yang sudah ada di Model Job
            ->with('company')
            ->whereNotIn('id', $appliedJobIds) // Filter job yang sudah dilamar
            ->inRandomOrder() // Tampilkan secara acak agar variatif
            ->take(3) // Batasi 3 rekomendasi
            ->get();

        $profile = $user->profile;

        return view('pelamar.dashboard', compact('stats', 'recentApplications', 'recommendedJobs', 'profile'));
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        return view('pelamar.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'nullable|max:15',
            'skills' => 'nullable|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Update user name
        $user->update(['name' => $request->name]);

        // Update or create profile
        $profileData = [
            'phone_number' => $request->phone_number,
            'skills' => $request->skills,
        ];

        // Handle CV upload
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $filename = 'cv_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Ensure file is saved to the 'public' disk so it is accessible via /storage
            Storage::disk('public')->putFileAs('cv', $file, $filename);
            $profileData['cv_file'] = $filename;
        }

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $profileData['id'] = Profile::generateId();
            $profileData['user_id'] = $user->id;
            Profile::create($profileData);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function applications()
    {
        $user = auth()->user();

        // Get applications with details
        $applications = DB::table('v_detail_lamaran')
            ->where('application_id', 'like', 'APP%')
            ->get();

        // If view doesn't work, fallback to eloquent
        $applications = Application::with(['job.company', 'job.category'])
            ->where('user_id', $user->id)
            ->orderBy('apply_date', 'desc')
            ->paginate(10);

        return view('pelamar.applications', compact('applications'));
    }

    public function apply(Request $request, $jobId)
    {
        $user = auth()->user();
        $job = Job::findOrFail($jobId);

        // Check if already applied
        $existingApplication = Application::where('user_id', $user->id)
            ->where('job_id', $jobId)
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah pernah melamar pekerjaan ini!');
        }

        // Check if job is still open
        if (!$job->isOpen()) {
            return back()->with('error', 'Lowongan sudah ditutup.');
        }

        // Check if job deadline has passed
        if ($job->isExpired()) {
            return back()->with('error', 'Deadline lamaran sudah berakhir.');
        }

        // Check if user has complete profile
        if (!$user->profile || !$user->profile->cv_file) {
            return back()->with('error', 'Lengkapi profil dan upload CV terlebih dahulu.');
        }

        // Create application
        Application::create([
            'id' => Application::generateId(),
            'job_id' => $jobId,
            'user_id' => $user->id,
            'apply_date' => now()->toDateString(),
            'status' => 'pending',
            'notes' => 'Lamaran via Website',
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim!');
    }

    public function cancelApplication($id)
    {
        $application = Application::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $application->delete();

        return back()->with('success', 'Lamaran berhasil dibatalkan.');
    }
}
