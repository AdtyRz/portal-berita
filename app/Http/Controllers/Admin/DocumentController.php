<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocumentRequest;
use App\Http\Requests\Admin\UpdateDocumentRequest;
use App\Models\ActivityLog;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->latest()->paginate(15)->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.form');
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file'] = $file->store('documents', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        $document = Document::create($data);
        ActivityLog::log('created', $document, "Created document: {$document->title}");

        return redirect()->route('admin.documents.index')->with('success', 'Document created successfully.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.form', compact('document'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($document->file) {
                Storage::disk('public')->delete($document->file);
            }
            $file = $request->file('file');
            $data['file'] = $file->store('documents', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        $document->update($data);
        ActivityLog::log('updated', $document, "Updated document: {$document->title}");

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $title = $document->title;
        if ($document->file) {
            Storage::disk('public')->delete($document->file);
        }
        $document->delete();
        ActivityLog::log('deleted', $document, "Deleted document: {$title}");

        return redirect()->route('admin.documents.index')->with('success', 'Document deleted successfully.');
    }
}
