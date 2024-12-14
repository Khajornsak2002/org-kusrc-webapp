<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentReceivingController extends Controller
{
    public function index()
    {
        $documents = Document::where('created_by', Auth::id())->get();
        return view('documents.document-receiving', compact('documents'));
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

    public function updateCheckboxStatus(Request $request) {
        $document = Document::find($request->id);
        if ($document) {
            $document->check_status = $request->check_status;
            $document->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
