<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentNotification;
use Log;
use App\Models\User;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $itemsPerPage = $request->input('itemsPerPage', 10); // Default to 10 if not set
        $documents = Document::where('created_by', Auth::id())->paginate($itemsPerPage); // Use paginate instead of get

        // Debugging: Check the number of documents retrieved
        Log::info('Documents retrieved: ', $documents->toArray());

        return view('documents.index', compact('documents', 'itemsPerPage'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:51200', // Updated max size to 50MB
            'status' => 'required|in:ผ่านแล้ว,แก้ไข', // Ensure only these statuses are allowed
            'remark' => 'nullable|string|max:255',
            'org_return' => 'required|string|max:255', // Add validation for org_return
            'check_status' => 'nullable|string|max:255', // Add validation for check_status if needed
        ]);

        // Handle the file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');
        }

        // Use the org_return value directly as org_return_id
        $orgReturnId = $request->input('org_return'); // Directly use the selected value

        // Debugging: Log the orgReturnId
        Log::info('orgReturnId:', ['id' => $orgReturnId]);

        // Save the document to the database
        Document::create([
            'title' => $request->input('title'),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'org_return' => $request->input('org_return'), // Ensure org_return is included
            'org_return_id' => $orgReturnId, // Save the org_return_id directly from the input
            'remark' => $request->input('remark'), // Add this line to save the remark
            'status' => $request->input('status'), // Add this line to save the status
            'check_status' => $request->input('check_status', 'default_value'), // Provide a value for check_status
            'created_by' => Auth::id(),
        ]);

        // Redirect back with a success message
        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function updateStatus(Request $request) {
        $document = Document::find($request->id);
        if ($document) {
            $document->status = $request->status;
            $document->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function receiving()
    {
        // Fetch documents for the logged-in user where org_return matches the user's name in the users table
        $documents = Document::whereHas('user', function($query) {
            $query->where('name', Auth::user()->org_return);
        })->get();

        // Ensure the documents variable is passed to the view
        return view('documents.document-receiving', compact('documents'));
    }

    public function sendDocument(Request $request)
    {
        // Fetch the document based on some criteria, e.g., ID from the request
        $document = Document::find($request->input('document_id'));

        if (!$document) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        // Fetch the organization email from the document's org_return column
        $organizationEmail = $document->org_return_email; // Ensure this column exists

        // Send email notification
        Mail::to($organizationEmail)->send(new DocumentNotification($document));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Document sent successfully.');
    }

    public function showDocuments()
    {
        // Fetch documents from the database where org_return matches the logged-in user's organization
        $documents = Document::where('org_return', Auth::user()->org_return) // Ensure this matches the user's organization
                            ->where('created_by', Auth::id())
                            ->get();

        // Pass the documents to the view
        return view('documents.document-receiving', compact('documents'));
    }


    // API documents
    public function apiIndex(Request $request)
    {
        $documents = Document::where('org_return', Auth::id())
            ->with('user:id,name') // เพิ่มการโหลดข้อมูลผู้ใช้ที่เกี่ยวข้อง
            ->get()
            ->map(function ($document) {
                // เปรียบเทียบ org_return_id กับ id ของผู้ใช้
                $user = User::find($document->org_return_id); // ค้นหาผู้ใช้ตาม org_return_id
                $document->org_return_name = $user->name ?? null; // เพิ่ม org_return_name
                return $document;
            });

        return response()->json($documents); // ส่งคืนเอกสารในรูปแบบ JSON
    }


}
