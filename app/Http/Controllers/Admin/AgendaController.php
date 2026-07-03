<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAgendaRequest;
use App\Http\Requests\Admin\UpdateAgendaRequest;
use App\Models\ActivityLog;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $agendas = $query->orderBy('start_date', 'desc')->paginate(15)->withQueryString();

        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.form');
    }

    public function store(StoreAgendaRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('agendas', 'public');
        }

        $agenda = Agenda::create($data);
        ActivityLog::log('created', $agenda, "Created agenda: {$agenda->title}");

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda created successfully.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.form', compact('agenda'));
    }

    public function update(UpdateAgendaRequest $request, Agenda $agenda)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($agenda->thumbnail) {
                Storage::disk('public')->delete($agenda->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('agendas', 'public');
        }

        $agenda->update($data);
        ActivityLog::log('updated', $agenda, "Updated agenda: {$agenda->title}");

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda updated successfully.');
    }

    public function destroy(Agenda $agenda)
    {
        $title = $agenda->title;
        if ($agenda->thumbnail) {
            Storage::disk('public')->delete($agenda->thumbnail);
        }
        $agenda->delete();
        ActivityLog::log('deleted', $agenda, "Deleted agenda: {$title}");

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda deleted successfully.');
    }
}
