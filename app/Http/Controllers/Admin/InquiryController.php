<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = \DB::table('inquiries')->latest()->paginate(15);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show($id)
    {
        $inquiry = \DB::table('inquiries')->find($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function destroy($id)
    {
        \DB::table('inquiries')->delete($id);
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}