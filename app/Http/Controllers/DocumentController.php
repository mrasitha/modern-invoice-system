<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Document;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function index() {
        $documents = Document::with('project')->latest()->get();
        return view('documents.index', compact('documents'));
    }
    
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

    // Status එක මාරු කිරීම (Ex: Pending -> Paid)
    public function updateStatus($id, $status)
    {
        $document = Document::findOrFail($id);
        $document->update(['status' => $status]);

        return back()->with('success', 'Status updated to ' . ucfirst($status));
    }

    public function convertToInvoice($id)
    {
        DB::transaction(function () use ($id) {
            $quote = Document::with('items')->findOrFail($id);

            // 1. අලුත් Invoice එකක් හදනවා පරණ Quote එකේ දත්ත පාවිච්චි කරලා
            $invoice = Document::create([
                'project_id'    => $quote->project_id,
                'doc_number'    => 'INV-' . time(),
                'type'          => 'invoice',
                'billing_mode'  => $quote->billing_mode,
                'total_amount'  => $quote->total_amount,
                'status'        => 'pending'
            ]);

            // 2. Quote එකේ තිබුණු Items ටික අලුත් Invoice එකටත් දානවා
            foreach ($quote->items as $item) {
                $invoice->items()->create([
                    'description' => $item->description,
                    'qty'         => $item->qty,
                    'unit_price'  => $item->unit_price,
                ]);
            }

            // 3. පරණ Quote එක "Accepted" කියලා mark කරනවා
            $quote->update(['status' => 'accepted']);
        });

        return redirect()->route('dashboard')->with('success', 'Quotation converted to Invoice!');
    }

   // viewPDF සහ downloadPDF කියන functions දෙකම මේ විදිහට update කරන්න
    public function viewPDF($id)
    {
        $document = Document::with(['project', 'items'])->findOrFail($id);
        
        // Settings ටික ගන්නවා
        $settings = Setting::pluck('value', 'key')->toArray();
        
        $pdf = Pdf::loadView('documents.pdf', compact('document', 'settings'));
        return $pdf->stream($document->doc_number . '.pdf');
    }

    public function downloadPDF($id)
    {
        $document = Document::with(['project', 'items'])->findOrFail($id);
        $settings = Setting::pluck('value', 'key')->toArray();
        
        $pdf = Pdf::loadView('documents.pdf', compact('document', 'settings'));
        return $pdf->download($document->doc_number . '.pdf');
    }
}