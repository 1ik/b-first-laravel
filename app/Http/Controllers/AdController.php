<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

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
        $request->image->move(public_path('images/ads'), $imageName);

        Ad::create([
            'image_path' => 'images/ads/'.$imageName,
            'page' => $request->page,
            'position' => $request->position,
        ]);

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
