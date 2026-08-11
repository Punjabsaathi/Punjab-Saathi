<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'inquiries' => Schema::hasTable('inquiries') ? DB::table('inquiries')->count() : 0,
            'blogs'     => Schema::hasTable('blogs')     ? DB::table('blogs')->count()     : 0,
            'projects'  => Schema::hasTable('projects')  ? DB::table('projects')->count()  : 0,
            'users'     => Schema::hasTable('users')     ? DB::table('users')->count()     : 0,
        ];

        $recentInquiries = Schema::hasTable('inquiries') ? DB::table('inquiries')->latest()->limit(5)->get() : collect();
        $recentBlogs     = Schema::hasTable('blogs')     ? DB::table('blogs')->latest()->limit(4)->get()     : collect();
        $recentProjects  = Schema::hasTable('projects')  ? DB::table('projects')->latest()->limit(4)->get()  : collect();

        return view('admin.dashboard', compact(
            'stats',
            'recentInquiries',
            'recentBlogs',
            'recentProjects'
        ));
    }
}