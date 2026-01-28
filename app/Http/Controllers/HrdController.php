<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;

class HrdController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('hrd.company.create')
                ->with('info', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }

        $jobIds = $company->jobs()->pluck('id');

        $stats = [
            'total_jobs' => $company->jobs()->count(),

            'active_jobs' => $company->jobs()->active()->count(),

            'total_applications' => Application::whereIn('job_id', $jobIds)->count(),

            'pending_applications' => Application::whereIn('job_id', $jobIds)
                ->where('status', 'pending')
                ->count(),
        ];

        $recentApplications = Application::with(['user', 'job'])
            ->whereIn('job_id', $jobIds)
            ->orderBy('apply_date', 'desc')
            ->take(5)
            ->get();

        $jobs = $company->jobs()
            ->withCount('applications')
            ->orderBy('deadline', 'desc')
            ->take(6)
            ->get();

        return view('hrd.dashboard', compact('company', 'stats', 'recentApplications', 'jobs'));
    }

    public function companyProfile()
    {
        $company = auth()->user()->company;
        return view('hrd.company.profile', compact('company'));
    }

    public function createCompany()
    {
        return view('hrd.company.create');
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'website' => 'nullable|url|max:100',
        ]);

        Company::create([
            'id' => Company::generateId(),
            'user_id' => auth()->id(),
            'company_name' => $request->company_name,
            'description' => $request->description,
            'address' => $request->address,
            'website' => $request->website,
            'status_verifikasi' => 'pending',
        ]);

        return redirect()->route('hrd.dashboard')
            ->with('success', 'Profil perusahaan berhasil dibuat! Menunggu verifikasi admin.');
    }

    public function updateCompany(Request $request)
    {
        $company = auth()->user()->company;

        $request->validate([
            'company_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'website' => 'nullable|max:100',
        ]);

        $company->update($request->only(['company_name', 'description', 'address', 'website']));

        return back()->with('success', 'Profil perusahaan berhasil diperbarui!');
    }

    // Job Management
    public function jobs()
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect()->route('hrd.company.create');
        }

        $jobs = $company->jobs()
            ->withCount('applications')
            ->orderBy('deadline', 'desc')
            ->paginate(10);

        return view('hrd.jobs.index', compact('jobs', 'company'));
    }

    public function createJob()
    {
        $company = auth()->user()->company;

        if (!$company || !$company->isApproved()) {
            return redirect()->route('hrd.dashboard')
                ->with('error', 'Perusahaan Anda belum diverifikasi. Silakan tunggu persetujuan admin.');
        }

        $categories = Category::all();
        return view('hrd.jobs.create', compact('categories'));
    }

    public function storeJob(Request $request)
    {
        $company = auth()->user()->company;

        if (!$company || !$company->isApproved()) {
            return back()->with('error', 'Perusahaan belum diverifikasi.');
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'salary_range' => 'nullable|string|max:50',
            'location' => 'required|string|max:50',
            'deadline' => 'required|date|after:today',
        ]);

        Job::create([
            'id' => Job::generateId(),
            'company_id' => $company->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'salary_range' => $request->salary_range ?: 'Disembunyikan',
            'location' => $request->location,
            'deadline' => $request->deadline,
            'status' => 'open',
        ]);

        return redirect()->route('hrd.jobs')
            ->with('success', 'Lowongan berhasil ditambahkan!');
    }

    public function editJob($id)
    {
        $job = Job::where('company_id', auth()->user()->company->id)
            ->findOrFail($id);
        $categories = Category::all();

        return view('hrd.jobs.edit', compact('job', 'categories'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::where('company_id', auth()->user()->company->id)
            ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'salary_range' => 'nullable|string|max:50',
            'location' => 'required|string|max:50',
            'deadline' => 'required|date',
            'status' => 'required|in:open,closed',
        ]);

        $job->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'salary_range' => $request->salary_range ?: 'Disembunyikan',
            'location' => $request->location,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('hrd.jobs')
            ->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function deleteJob($id)
    {
        $job = Job::where('company_id', auth()->user()->company->id)
            ->findOrFail($id);

        $job->delete();

        return back()->with('success', 'Lowongan berhasil dihapus!');
    }

    // Applicant Management
    public function applicants($jobId = null)
    {
        $company = auth()->user()->company;
        $jobIds = $company->jobs()->pluck('id');

        $query = Application::with(['job', 'user.profile'])
            ->whereIn('job_id', $jobIds);

        if ($jobId) {
            $query->where('job_id', $jobId);
        }

        $applications = $query->orderBy('apply_date', 'desc')->paginate(15);
        $jobs = $company->jobs()->get();

        return view('hrd.applicants.index', compact('applications', 'jobs', 'jobId'));
    }

    public function showApplicant($id)
    {
        $company = auth()->user()->company;

        $application = Application::with(['job', 'user.profile'])
            ->whereIn('job_id', $company->jobs()->pluck('id'))
            ->findOrFail($id);

        return view('hrd.applicants.show', compact('application'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $company = auth()->user()->company;

        $application = Application::whereIn('job_id', $company->jobs()->pluck('id'))
            ->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,interview,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
        
        if ($request->status === 'accepted') {
            $application->job->update(['status' => 'closed']);
        }

        return back()->with('success', 'Status lamaran berhasil diperbarui!');
    }
}
