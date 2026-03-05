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
}