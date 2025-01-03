<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function sitemapStotries(){
        $today = Carbon::now();
        $oneMonthAgo = $today->copy()->subMonth()->startOfDay();
        $endOfDay = $today->endOfDay();
        
        $stories = Story::with(['tags'])->select('id','title','meta','created_at','updated_at')->where('created_at', '>=', $oneMonthAgo)
                         ->where('created_at', '<=', $endOfDay)
                         ->get();
        return $stories;
    }
}
