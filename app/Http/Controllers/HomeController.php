<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $popularJobs = DB::table('v_loker_populer')
            ->take(6)
            ->get();

        $activeJobs = DB::table('v_loker_aktif')
            ->take(8)
            ->get();

        $categories = DB::table('v_statistik_kategori')->get();

        $stats = [
            'total_jobs' => Job::count(),
            'total_companies' => DB::table('companies')->where('status_verifikasi', 'approved')->count(),
            'total_users' => DB::table('users')->where('role', 'pelamar')->count(),
        ];

        return view('home', compact('popularJobs', 'activeJobs', 'categories', 'stats'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $location = $request->input('location');
        $categoryId = $request->input('category');

        $query = Job::with(['company', 'category'])
            ->active()
            ->whereHas('company', function ($q) {
                $q->approved();
            });

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($location) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $jobs = $query->orderBy('deadline', 'desc')->paginate(12);
        $allCategories = Category::all();

        return view('jobs.search', compact('jobs', 'allCategories', 'keyword', 'location', 'categoryId'));
    }

    public function showJob($id)
    {
        $job = Job::with(['company', 'category'])->findOrFail($id);

        $relatedJobs = Job::with(['company'])
            ->active()
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->take(4)
            ->get();

        $hasApplied = false;
        if (auth()->check() && auth()->user()->isPelamar()) {
            $hasApplied = $job->applications()
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('jobs.show', compact('job', 'relatedJobs', 'hasApplied'));
    }
}
