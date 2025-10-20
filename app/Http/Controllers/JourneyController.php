<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\JourneyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class JourneyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $journey = Journey::with('images')->findOrFail($id);
        return view('journey.show', compact('journey'));
    }

    public function create()
    {
        return view('journey.create');
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
        ]);
        DB::beginTransaction();
        try {
            $journey = Journey::create([
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
                    $path = $image->store('journey_images', 'public');
                    JourneyImage::create([
                        'journey_id' => $journey->id,
                        'image_path' => $path,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Journey created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            // \Log::error('Journey store error: '.$e->getMessage());
            return back()->withErrors('An error occurred while saving.')->withInput();
        }
    }

    public function edit(Journey $journey)
    {
        if ($journey->user_id !== auth()->id()) {
            abort(403);
        }
        $journey->load('images');
        return view('journey.edit', compact('journey'));
    }

    public function update(Request $request, Journey $journey)
    {
        if ($journey->user_id !== auth()->id()) {
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
            $journey->update([
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
                    $path = $image->store('journey_images', 'public');
                    JourneyImage::create([
                        'journey_id' => $journey->id,
                        'image_path' => $path,
                    ]);
                }
            }
            // Delete images if needed
            if ($request->filled('deleted_images')) {
                $imageIdsToDelete = explode(',', $request->input('deleted_images'));
                foreach ($imageIdsToDelete as $id) {
                    $image = JourneyImage::find($id);
                    if ($image && $image->journey_id === $journey->id) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Journey updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Journey update error: ' . $e->getMessage());
            return back()->withErrors('Failed to update journey.')->withInput();
        }
    }

    public function destroy(Journey $journey)
    {
        if ($journey->user_id !== auth()->id()) {
            abort(403);
        }
        DB::beginTransaction();
        try {
            foreach ($journey->images as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
            }
            $journey->delete();
            DB::commit();
            return redirect()->route('home')->with('success', 'Journey deleted successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Journey delete error: ' . $e->getMessage());
            return back()->withErrors('Failed to delete journey.');
        }
    }

}