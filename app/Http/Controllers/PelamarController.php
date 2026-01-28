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

        $query = Application::where('user_id', $user->id);

        $stats = [
            'total_applications' => (clone $query)->count(),
            'pending'   => (clone $query)->where('status', 'pending')->count(),
            'interview' => (clone $query)->where('status', 'interview')->count(),
            'accepted'  => (clone $query)->where('status', 'accepted')->count(),
            'rejected'  => (clone $query)->where('status', 'rejected')->count(),
        ];


        $recentApplications = Application::with(['job.company'])
            ->where('user_id', $user->id)
            ->orderBy('apply_date', 'desc')
            ->take(5)
            ->get();

        $appliedJobIds = Application::where('user_id', $user->id)->pluck('job_id');

        $recommendedJobs = Job::active()
            ->with('company')
            ->whereNotIn('id', $appliedJobIds)
            ->inRandomOrder()
            ->take(3)
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

        $user->update(['name' => $request->name]);

        $profileData = [
            'phone_number' => $request->phone_number,
            'skills' => $request->skills,
        ];

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $filename = 'cv_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
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

        $applications = DB::table('v_detail_lamaran')
            ->where('application_id', 'like', 'APP%')
            ->get();

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

        $existingApplication = Application::where('user_id', $user->id)
            ->where('job_id', $jobId)
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah pernah melamar pekerjaan ini!');
        }

        if (!$job->isOpen()) {
            return back()->with('error', 'Lowongan sudah ditutup.');
        }

        if ($job->isExpired()) {
            return back()->with('error', 'Deadline lamaran sudah berakhir.');
        }

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
