<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ප්‍රධාන ගණනය කිරීම්
        $totalInvoiced = Document::where('type', 'invoice')->sum('total_amount');
        $totalPaid = Document::where('type', 'invoice')->where('status', 'paid')->sum('total_amount');
        $totalQuotes = Document::where('type', 'quotation')->sum('total_amount');
        
        // Pending ගණන් (Invoices සහ Quotes දෙකම)
        $pendingInvoicesCount = Document::where('type', 'invoice')->where('status', 'pending')->count();
        $pendingQuotesCount = Document::where('type', 'quotation')->where('status', 'pending')->count();
        
        // Profit (Paid invoices වලින් 20% ක් ලෙස උදාහරණයකට ගනිමු - ඔයාට කැමති විදිහට වෙනස් කළ හැක)
        $estimatedProfit = $totalPaid * 0.20; 

        // ව්‍යාපෘති ගණන
        $activeProjectsCount = Project::count();

        // Chart දත්ත (මාස 6)
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('M'));
        $invoiceData = collect(range(5, 0))->map(fn($i) => Document::where('type', 'invoice')->whereMonth('created_at', now()->subMonths($i)->month)->sum('total_amount'));
        $quoteData = collect(range(5, 0))->map(fn($i) => Document::where('type', 'quotation')->whereMonth('created_at', now()->subMonths($i)->month)->sum('total_amount'));

        return view('dashboard', compact(
            'totalInvoiced', 'totalPaid', 'totalQuotes', 'pendingInvoicesCount', 
            'pendingQuotesCount', 'estimatedProfit', 'activeProjectsCount',
            'months', 'invoiceData', 'quoteData'
        ));
    }
}