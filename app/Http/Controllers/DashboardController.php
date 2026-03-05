<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        // සියලුම Invoice වල එකතුව (Total Invoiced)
        $totalInvoiced = Document::where('type', 'invoice')->sum('total_amount');
        
        // ගෙවා අවසන් කළ (Paid) මුදල - (අපි පසුව Status update කරනවා)
        $totalPaid = Document::where('status', 'paid')->sum('total_amount');
        
        // පෙන්ඩින් Quotations ගණන
        $pendingQuotes = Document::where('type', 'quotation')->where('status', 'pending')->count();
        
        // අවසානයට කරපු ගනුදෙනු 5ක් (Recent History)
        $recentDocs = Document::with('project')->latest()->take(5)->get();

        return view('dashboard', compact('totalInvoiced', 'totalPaid', 'pendingQuotes', 'recentDocs'));
    }
}