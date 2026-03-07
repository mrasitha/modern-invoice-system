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
    public function index(Request $request) {
        $query = Document::with('project')->latest();

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('doc_number', 'LIKE', "%$search%")
                ->orWhereHas('project', function($pq) use ($search) {
                    $pq->where('name', 'LIKE', "%$search%")
                        ->orWhere('client_name', 'LIKE', "%$search%");
                });
            });
        }

        // Type Filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $documents = $query->get();
        return view('documents.index', compact('documents'));
    }
    
    public function create() {
        $projects = Project::all();
        return view('documents.create', compact('projects'));
    }

    public function store(Request $request) {
        $request->validate([
            'project_id' => 'required',
            'type' => 'required',
            'items' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $prefix = ($request->type == 'invoice') ? 'INV' : 'QUO';
            
            // Serial Number එක ගණනය කිරීම
            $lastDoc = Document::where('type', $request->type)->latest()->first();
            $nextId = $lastDoc ? ((int) explode('-', $lastDoc->doc_number)[1]) + 1 : 1;
            $docNumber = $prefix . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $document = Document::create([
                'project_id'   => $request->project_id,
                'doc_number'   => $docNumber,
                'type'         => $request->type,
                'billing_mode' => $request->billing_mode,
                'status'       => 'pending'
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $document->items()->create([
                    'description' => $item['desc'],
                    'qty'         => $item['qty'],
                    'unit_price'  => $item['price']
                ]);
                $total += ($item['qty'] * $item['price']);
            }

            $document->update(['total_amount' => $total]);
        });

        return redirect('/')->with('success', 'Document created successfully!');
    }

    public function convertToInvoice($id)
    {
        DB::transaction(function () use ($id) {
            $quote = Document::with('items')->findOrFail($id);

            // මෙතනත් Serial Number එක හරි විදිහට ගමු
            $lastInvoice = Document::where('type', 'invoice')->latest()->first();
            $nextId = $lastInvoice ? ((int) explode('-', $lastInvoice->doc_number)[1]) + 1 : 1;
            $docNumber = 'INV-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $invoice = Document::create([
                'project_id'    => $quote->project_id,
                'doc_number'    => $docNumber, // Serial number එක මෙතනට ආදේශ කළා
                'type'          => 'invoice',
                'billing_mode'  => $quote->billing_mode,
                'total_amount'  => $quote->total_amount,
                'status'        => 'pending'
            ]);

            foreach ($quote->items as $item) {
                $invoice->items()->create([
                    'description' => $item->description,
                    'qty'         => $item->qty,
                    'unit_price'  => $item->unit_price,
                ]);
            }

            $quote->update(['status' => 'accepted']);
        });

        return redirect()->route('dashboard')->with('success', 'Quotation converted to Invoice!');
    }

    // Status එක මාරු කිරීම (Ex: Pending -> Paid)
    public function updateStatus($id, $status)
    {
        $document = Document::findOrFail($id);
        $document->update(['status' => $status]);

        return back()->with('success', 'Status updated to ' . ucfirst($status));
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