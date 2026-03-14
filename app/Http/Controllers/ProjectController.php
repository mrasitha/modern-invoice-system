<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // සියලුම Projects පෙන්වීමට
    public function index() {
        $projects = Project::withCount('documents')->latest()->get();
        return view('projects.index', compact('projects'));
    }

    // අලුත් Project එකක් Save කිරීමට
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
        ]);

        Project::create([
            'name' => $request->name,
            'client_name' => $request->client_name,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created!');
    }

    // Project එකක සම්පූර්ණ History එක බැලීමට (Single View)
    public function show($id) {
        // Magic Method: with('documents.items') පාවිච්චි කරලා ඔක්කොම එකපාර ගන්නවා
        $project = Project::with(['documents.items'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    public function getStats($id) {
        try {
            $project = Project::with('documents')->findOrFail($id);
            
            // 1. අපි දැනට නිකුත් කර ඇති මුළු ඉන්වොයිස් වටිනාකම (Total Invoiced)
            $totalInvoiced = $project->documents()
                                    ->where('type', 'invoice')
                                    ->sum('total_amount');
            
            // 2. ඒ ඉන්වොයිස් වලින් ක්ලියන්ට් දැනටමත් ගෙවා ඇති මුළු මුදල (Total Paid)
            $paidAmount = $project->documents()
                                ->where('type', 'invoice')
                                ->where('status', 'paid')
                                ->sum('total_amount');
            
            // 3. ඉන්වොයිස් කරපු මුදලින් තව ලැබිය යුතු ශේෂය (Balance Due)
            $dueAmount = $totalInvoiced - $paidAmount;

            return response()->json([
                'total' => number_format($totalInvoiced, 2, '.', ''), // Formatting without commas for JS
                'paid'  => number_format($paidAmount, 2, '.', ''),
                'due'   => number_format($dueAmount, 2, '.', '')
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}