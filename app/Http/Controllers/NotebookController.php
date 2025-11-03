<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Models\NotebookImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NotebookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notebooks = Notebook::with('images')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('notebook.index', compact('notebooks'));
    }

    public function show($id)
    {
        $notebook = Notebook::with('images')->findOrFail($id);
        return view('notebook.show', compact('notebook'));
    }

    public function create()
    {
        return view('notebook.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'story' => 'required|string',
            'processional' => 'nullable|string',
            'life_reflection' => 'nullable|string',
            'song_selection' => 'nullable|string',
            'life_scriptures' => 'nullable|string',
            'prayer' => 'nullable|string',
            'resolution' => 'nullable|string',
            'acknowledgment' => 'nullable|string',
            'expression' => 'nullable|string',
            'invitation_of_discipleship' => 'nullable|string',
            'recessional' => 'nullable|string',
            'honorary_pallbearers' => 'nullable|string',
            'grateful_hearts' => 'nullable|string',
            'interment' => 'nullable|string',
            'final_arrangement_entrusted_to' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ],[
            'images.*.image' => 'Each uploaded file type must be an image.',
            'images.*.mimes' => 'Each image must be a file format type: jpeg, png, jpg or gif.',
            'images.*.max' => 'Each image may not be larger than 8MB.',
        ]);
        DB::beginTransaction();
        try {
            $notebook = Notebook::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'date' => $validated['date'],
                'story' => $validated['story'],
                'processional' => $validated['processional'] ?? null,
                'life_reflection' => $validated['life_reflection'] ?? null,
                'song_selection' => $validated['song_selection'] ?? null,
                'life_scriptures' => $validated['life_scriptures'] ?? null,
                'prayer' => $validated['prayer'] ?? null,
                'resolution' => $validated['resolution'] ?? null,
                'acknowledgment' => $validated['acknowledgment'] ?? null,
                'expression' => $validated['expression'] ?? null,
                'invitation_of_discipleship' => $validated['invitation_of_discipleship'] ?? null,
                'recessional' => $validated['recessional'] ?? null,
                'honorary_pallbearers' => $validated['honorary_pallbearers'] ?? null,
                'grateful_hearts' => $validated['grateful_hearts'] ?? null,
                'interment' => $validated['interment'] ?? null,
                'final_arrangement_entrusted_to' => $validated['final_arrangement_entrusted_to'] ?? null,
            ]);
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('notebook_images', 'public');
                    NotebookImage::create([
                        'notebook_id' => $notebook->id,
                        'image_path' => $path,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('notebook.index')->with('success', 'Notebook created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            // \Log::error('Notebook store error: '.$e->getMessage());
            return back()->withErrors('An error occurred while saving.')->withInput();
        }
    }

    public function edit(Notebook $notebook)
    {
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        $notebook->load('images');
        return view('notebook.edit', compact('notebook'));
    }

    public function update(Request $request, Notebook $notebook)
    {
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'story' => 'required|string',
            'processional' => 'nullable|string',
            'life_reflection' => 'nullable|string',
            'song_selection' => 'nullable|string',
            'life_scriptures' => 'nullable|string',
            'prayer' => 'nullable|string',
            'resolution' => 'nullable|string',
            'acknowledgment' => 'nullable|string',
            'expression' => 'nullable|string',
            'invitation_of_discipleship' => 'nullable|string',
            'recessional' => 'nullable|string',
            'honorary_pallbearers' => 'nullable|string',
            'grateful_hearts' => 'nullable|string',
            'interment' => 'nullable|string',
            'final_arrangement_entrusted_to' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);
        DB::beginTransaction();
        try {
            $notebook->update([
                'title' => $validated['title'],
                'date' => $validated['date'],
                'story' => $validated['story'],
                'processional' => $validated['processional'] ?? null,
                'life_reflection' => $validated['life_reflection'] ?? null,
                'song_selection' => $validated['song_selection'] ?? null,
                'life_scriptures' => $validated['life_scriptures'] ?? null,
                'prayer' => $validated['prayer'] ?? null,
                'resolution' => $validated['resolution'] ?? null,
                'acknowledgment' => $validated['acknowledgment'] ?? null,
                'expression' => $validated['expression'] ?? null,
                'invitation_of_discipleship' => $validated['invitation_of_discipleship'] ?? null,
                'recessional' => $validated['recessional'] ?? null,
                'honorary_pallbearers' => $validated['honorary_pallbearers'] ?? null,
                'grateful_hearts' => $validated['grateful_hearts'] ?? null,
                'interment' => $validated['interment'] ?? null,
                'final_arrangement_entrusted_to' => $validated['final_arrangement_entrusted_to'] ?? null,
            ]);
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('notebook_images', 'public');
                    NotebookImage::create([
                        'notebook_id' => $notebook->id,
                        'image_path' => $path,
                    ]);
                }
            }
            // Delete images if needed
            if ($request->filled('deleted_images')) {
                $imageIdsToDelete = explode(',', $request->input('deleted_images'));
                foreach ($imageIdsToDelete as $id) {
                    $image = NotebookImage::find($id);
                    if ($image && $image->notebook_id === $notebook->id) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }
            DB::commit();
            return redirect()->route('notebook.index')->with('success', 'Notebook updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Notebook update error: ' . $e->getMessage());
            return back()->withErrors('Failed to update notebook.')->withInput();
        }
    }

    public function destroy(Notebook $notebook)
    {
        if ($notebook->user_id !== auth()->id()) {
            abort(403);
        }
        DB::beginTransaction();
        try {
            foreach ($notebook->images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
            }
            $notebook->delete();
            DB::commit();
            return redirect()->route('home')->with('success', 'Notebook deleted successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Notebook delete error: ' . $e->getMessage());
            return back()->withErrors('Failed to delete notebook.');
        }
    }

}