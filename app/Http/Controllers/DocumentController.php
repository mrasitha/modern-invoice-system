<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function create() {
        $projects = Project::all();
        return view('documents.create', compact('projects'));
    }

    public function store(Request $request) {
        // Validation - දත්ත නිවැරදිදැයි බැලීම
        $request->validate([
            'project_id' => 'required',
            'type' => 'required',
            'items' => 'required|array',
        ]);

        // DB Transaction - එකක් හරි වැරදුණොත් මුකුත් Save වෙන්නේ නැහැ (Data safety)
        DB::transaction(function () use ($request) {
            $document = Document::create([
                'project_id' => $request->project_id,
                'doc_number' => strtoupper($request->type[0]) . '-' . time(), // Ex: I-123456
                'type' => $request->type,
                'billing_mode' => $request->billing_mode,
                'status' => 'pending'
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $document->items()->create([
                    'description' => $item['desc'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['price']
                ]);
                $total += ($item['qty'] * $item['price']);
            }

            // මුළු එකතුව Update කිරීම
            $document->update(['total_amount' => $total]);
        });

        return redirect('/')->with('success', 'Document created successfully!');
    }
}