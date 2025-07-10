<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resume;
use App\Models\Template;
use Illuminate\Support\Facades\DB; // For direct DB queries if needed

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userCount = User::count();
        $resumeCount = Resume::count();
        $activeTemplateCount = Template::where('is_active', true)->count();
        $totalTemplateCount = Template::count();

        $resumeTypeCounts = Resume::select('format_type', DB::raw('count(*) as total'))
                                   ->groupBy('format_type')
                                   ->pluck('total', 'format_type');

        $atsResumeCount = $resumeTypeCounts->get('ats', 0);
        $styledResumeCount = $resumeTypeCounts->get('styled', 0);

        // Could also get counts for draft vs published resumes
        $draftResumeCount = Resume::where('is_draft', true)->count();
        $publishedResumeCount = Resume::where('is_draft', false)->count();


        return view('admin.dashboard', compact(
            'userCount',
            'resumeCount',
            'activeTemplateCount',
            'totalTemplateCount',
            'atsResumeCount',
            'styledResumeCount',
            'draftResumeCount',
            'publishedResumeCount'
        ));
    }
}
