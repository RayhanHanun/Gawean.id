<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\Company;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_pelamar' => User::where('role', 'pelamar')->count(),
            'total_hrd' => User::where('role', 'hrd')->count(),
            'total_companies' => Company::count(),
            'pending_companies' => Company::where('status_verifikasi', 'pending')->count(),
            'approved_companies' => Company::where('status_verifikasi', 'approved')->count(),
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('status', 'open')->count(),
            'total_applications' => Application::count(),
        ];

        $pendingCompanies = Company::where('status_verifikasi', 'pending')
            ->with('user')
            ->take(5)
            ->get();

        $recentApplications = Application::with(['job.company', 'user'])
            ->orderBy('apply_date', 'desc')
            ->take(10)
            ->get();

        try {
            $companyStats = DB::table('v_rekap_perusahaan')->get();
        } catch (\Exception $e) {
            $companyStats = Company::with('jobs')->take(5)->get();
        }

        return view('admin.dashboard', compact('stats', 'pendingCompanies', 'recentApplications', 'companyStats'));
    }

    // Company Verification
    public function companies(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Company::with('user');

        if ($status !== 'all') {
            $query->where('status_verifikasi', $status);
        }

        $companies = $query->orderBy('status_verifikasi')->paginate(15);

        return view('admin.companies.index', compact('companies', 'status'));
    }

    public function pendingCompanies()
    {
        $companies = DB::table('v_perusahaan_pending')->paginate(15);
        return view('admin.companies.pending', compact('companies'));
    }

    public function approveCompany($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status_verifikasi' => 'approved']);

        return back()->with('success', "Perusahaan {$company->company_name} berhasil diverifikasi!");
    }

    public function rejectCompany($id)
    {
        $company = Company::findOrFail($id);
        $company->update(['status_verifikasi' => 'rejected']);

        return back()->with('success', "Perusahaan {$company->company_name} ditolak.");
    }

    public function editCompany($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function updateCompany(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'company_name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'status_verifikasi' => 'required|in:pending,approved,rejected',
        ]);

        $company->update($validated);

        return redirect()->route('admin.companies')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroyCompany($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('admin.companies')->with('success', 'Perusahaan berhasil dihapus.');
    }

    // User Management
    public function users(Request $request)
    {
        $role = $request->input('role', 'all');

        $query = User::with('profile');

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users', 'role'));
    }

    public function showUser($id)
    {
        $user = User::with(['profile', 'company', 'applications.job'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }

    // Job Management
    public function jobs(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Job::with(['company', 'category'])->withCount('applications');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $jobs = $query->orderBy('deadline', 'desc')->paginate(20);

        return view('admin.jobs.index', compact('jobs', 'status'));
    }

    public function editJob($id)
    {
        $job = Job::findOrFail($id);
        $categories = Category::all();

        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'salary_range' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:open,closed',
        ]);

        $job->update($validated);

        return redirect()->route('admin.jobs')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroyJob($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs')->with('success', 'Lowongan berhasil dihapus.');
    }

    // Category Management
    public function categories()
    {
        $categories = Category::withCount('jobs')->get();
        $categoryStats = DB::table('v_statistik_kategori')->get();

        return view('admin.categories.index', compact('categories', 'categoryStats'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        Category::create([
            'id' => Category::generateId(),
            'name' => $request->name,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $id,
        ]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->jobs()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki lowongan.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }

    // HRD List
    public function hrdList()
    {
        $hrdList = DB::table('v_daftar_hrd')->paginate(15);
        return view('admin.hrd.index', compact('hrdList'));
    }

    // Reports
    public function reports()
    {
        try {
            $popularJobs = DB::table('v_loker_populer')->get();
        } catch (\Exception $e) {
            $popularJobs = Job::with('company')
                ->withCount('applications')
                ->orderBy('applications_count', 'desc')
                ->take(10)
                ->get();
        }

        try {
            $categoryStats = DB::table('v_statistik_kategori')->get();
        } catch (\Exception $e) {
            $categoryStats = Category::withCount('jobs')->get();
        }

        try {
            $companyStats = DB::table('v_rekap_perusahaan')->get();
        } catch (\Exception $e) {
            $companyStats = Company::with('jobs')->take(10)->get();
        }

        return view('admin.reports', compact('popularJobs', 'categoryStats', 'companyStats'));
    }
}
