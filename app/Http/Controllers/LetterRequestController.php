<?php

namespace App\Http\Controllers;

use App\Models\LetterRequest;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterRequestController extends Controller
{
    // Middleware will be applied via routes

    public function index()
    {
        $requests = auth()->user()->letterRequests()
            ->with('letterType')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('letter-requests.index', compact('requests'));
    }

    public function create()
    {
        $letterTypes = LetterType::active()->get();
        return view('letter-requests.create', compact('letterTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'form_data' => 'required|array',
        ]);

        $letterType = LetterType::findOrFail($request->letter_type_id);

        // Validate required fields based on letter type
        if ($letterType->required_fields) {
            foreach ($letterType->required_fields as $field => $type) {
                $request->validate([
                    "form_data.{$field}" => 'required'
                ]);
            }
        }

        // Generate request number
        $requestNumber = 'REQ-' . date('Ymd') . '-' . str_pad(
            LetterRequest::whereDate('created_at', today())->count() + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        LetterRequest::create([
            'request_number' => $requestNumber,
            'user_id' => auth()->id(),
            'letter_type_id' => $request->letter_type_id,
            'form_data' => $request->form_data,
            'status' => 'pending_rt',
        ]);

        return redirect()->route('letter-requests.index')
            ->with('success', 'Pengajuan surat berhasil dibuat dengan nomor: ' . $requestNumber);
    }

    public function show(LetterRequest $letterRequest)
    {
        // Ensure user can only view their own requests
        if ($letterRequest->user_id !== auth()->id()) {
            abort(403);
        }

        $letterRequest->load(['letterType', 'approvals.approver']);

        return view('letter-requests.show', compact('letterRequest'));
    }

    public function download(LetterRequest $letterRequest)
    {
        // Ensure user can only download their own approved letters
        if ($letterRequest->user_id !== auth()->id() || !$letterRequest->isApproved()) {
            abort(403);
        }

        if (!$letterRequest->letter_file || !file_exists(storage_path('app/public/' . $letterRequest->letter_file))) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan.');
        }

        return response()->download(
            storage_path('app/public/' . $letterRequest->letter_file),
            'Surat_' . $letterRequest->request_number . '.pdf'
        );
    }
}
