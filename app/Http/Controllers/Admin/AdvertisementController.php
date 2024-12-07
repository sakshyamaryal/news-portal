<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    // Constructor to check if the user has permission
    public function __construct()
    {
        $access = $this->middleware('can:manage advertisements');
        if (!$access) {
            abort(403, 'You do not have access to this page');
        }
    }

    public function index()
    {
        try {
            $advertisements = Advertisement::all();
            return view('advertisements.index', compact('advertisements'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
                'link_url' => 'required',
                'is_active' => 'boolean',
            ]);

            $image = $request->file('image');
            $imagePath = $image->store('advertisements', 'public'); 

            $advertisement = Advertisement::create([
                'title' => $request->title,
                'image_url' => Storage::url($imagePath), 
                'link_url' => $request->link_url,
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json([
                'id' => $advertisement->id,
                'title' => $advertisement->title,
                'image_url' => $advertisement->image_url,
                'link_url' => $advertisement->link_url,
                'is_active' => $advertisement->is_active,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create advertisement: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $advertisement = Advertisement::findOrFail($id);
            return response()->json($advertisement);
        } catch (Exception $e) {
            return response()->json(['error' => 'Advertisement not found!'], 404);
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
                'link_url' => 'required',
                'is_active' => 'boolean',
            ]);

            $advertisement = Advertisement::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('advertisements', 'public'); 
                $advertisement->image_url = Storage::url($imagePath);  
            }

            $advertisement->title = $request->title;
            $advertisement->link_url = $request->link_url;
            $advertisement->is_active = $request->is_active ?? true;

            $advertisement->save();

            return response()->json([
                'id' => $advertisement->id,
                'title' => $advertisement->title,
                'image_url' => $advertisement->image_url,
                'link_url' => $advertisement->link_url,
                'is_active' => $advertisement->is_active,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update advertisement: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $advertisement = Advertisement::findOrFail($id);
            $advertisement->delete();

            return response()->json(['success' => true, 'message' => 'Advertisement deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete advertisement: ' . $e->getMessage()], 500);
        }
    }
}