<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page' => 'required|string',
            'position' => 'required|string',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/user_uploads'), $imageName);

        $ad = Ad::where('page', $request->page)
        ->where('position', $request->position)
        ->first();

        if ($ad) {
            // Delete the existing image file if it exists
            $existingImagePath = public_path($ad->image_path);
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
    
            // Update existing ad with new image path
            $ad->image_path = 'images/user_uploads/' . $imageName;
            $ad->save();
        } else {
            // Create new ad
            Ad::create([
                'image_path' => 'images/user_uploads/' . $imageName,
                'page' => $request->page,
                'position' => $request->position,
            ]);
        }

        return response()->json(['message' => 'Ad created successfully.']);
    }

    public function getAdsByPage(Request $request)
    {
        $page = $request->query('page');

        $ads = Ad::where('page', $page)
            ->get();
        if ($ads->isEmpty()) {
            return response()->json(['message' => 'No ads found for this page.'], 404);
        }
        return response()->json(['ads' => $ads], 200);
    }
}
