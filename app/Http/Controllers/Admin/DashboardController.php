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

        $monthlyInquiries = $this->monthlyCounts('inquiries');
        $monthlyBlogs     = $this->monthlyCounts('blogs');

        return view('admin.dashboard', compact(
            'stats',
            'recentInquiries',
            'recentBlogs',
            'recentProjects',
            'monthlyInquiries',
            'monthlyBlogs'
        ));
    }

    private function monthlyCounts(string $table): array
    {
        $counts = array_fill(1, 12, 0);

        if (! Schema::hasTable($table)) {
            return array_values($counts);
        }

        DB::table($table)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->each(function ($total, $month) use (&$counts) {
                $counts[$month] = $total;
            });

        return array_values($counts);
    }
}