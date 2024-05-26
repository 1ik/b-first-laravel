<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StoryResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\FeaturedStories;
use App\Models\RecommendedStories;
use App\Models\Story;
use App\Models\Tag;
use App\Models\TrendyTopic;
use Illuminate\Http\Request;


class FrontendController extends Controller
{
    public function allCategories(){

        return CategoryResource::collection(Category::all());
    }
    public function latestStories(Request $request){
        $pageSize = $request->input('size', 20);
        return StoryResource::collection(Story::with(['authors', 'categories', 'tags'])->latest()->paginate($pageSize));
    }

    public function categoryStories(Request $request,$category){

        $pageSize = $request->input('size', 20);
        $category = Category::where('name', $category)->first();

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $stories = $category->stories()->with('authors', 'tags','categories')->orderBy('id', 'desc')->paginate($pageSize); 

        return StoryResource::collection($stories);
    }
    public function storyDetails(Story $story){

        return response()->json([
            'message'   => 'Story retrieved successfully',
            'story'     => new StoryResource($story->load('authors', 'tags', 'categories')),
        ], 200);
    }

    public function previewStory(Story $story){
        $story_image = json_decode($story->meta);
        $title = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', str_replace(' ', '-', $story->title)));
        $featured_image = isset($story_image->featured_image) ? $story_image->featured_image : null;
        $data = '<!DOCTYPE html>
                  <html lang="en">
                    <head>
                      <meta charset="UTF-8" />
                      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                      <style>
                        html {
                          overflow: hidden;
                          font-family: system-ui;
                        }
                        div {
                          display: flex;
                          justify-content: space-between;
                          align-items: center;
                        }
                        h2 {
                          font-size: 1.2rem;
                        }
                        a {
                          text-decoration: none;
                          color: #101828;
                          transition: 200ms;
                        }
                        a:hover {
                          color: #1779BA;
                        }
                        img {
                          width: 200px;
                          height: 116px;
                          object-fit: cover;
                          border-radius: 5px;
                        }
                  
                        @media (max-width: 500px) {
                          html {
                            height: 300px;
                          }
                          div {
                            flex-direction: column-reverse;
                          }
                        }
                      </style>
                      <title>news-preview</title>
                    </head>
                    <body>
                      <div>
                          <h2>
                            <a href="https://bangladeshfirst.com/news/'.$story->id.'/'.$title.'"
                              target="_blank"
                              >
                              '.$story->title.'
                              </a>
                              </h2>
                        
                              <a href="https://bangladeshfirst.com/news/'.$story->id.'/'.$title.'"
                              target="_blank"
                              >
                              <img src="https://images.bangladeshfirst.com/resize?width=200&height=112&format=webp&quality=85&path='.$featured_image.'"
                              alt="placeholder-img"
                              />
                              </a>
                              </div>
                    </body>
                  </html>';

        return $data;          
    }

    public function categoryFeaturedStories(Request $request, $category){
      $size = $request-> input('size', 11);

      $featured_stories = FeaturedStories::where('category_id',$category)->first();
      $stories = []; 
      if ($featured_stories) {
          $storyIdsString = implode(',', $featured_stories->story_ids);
          $stories = Story::with(['authors', 'categories', 'tags'])->whereIn('id', $featured_stories->story_ids)->orderByRaw("FIELD(id,$storyIdsString)")->take($size)->get();
      }

      return StoryResource::collection($stories);
    }

    public function recommendedStories(){
      $recommendedStories = RecommendedStories::first();
        $stories = [];
        if ($recommendedStories) {
            $storyIdsString = implode(',', $recommendedStories->story_ids);
            $stories = Story::with(['authors', 'categories', 'tags'])
                ->whereIn('id', $recommendedStories->story_ids)
                ->orderByRaw("FIELD(id, $storyIdsString)")
                ->get();
        }

        return StoryResource::collection($stories);
    }

    public function trendyTopics(){
       $trendy_topics = TrendyTopic::first();
       $tags = [];
       if($trendy_topics){
          $tagIdsString = implode(',', $trendy_topics->tag_ids);
          $tags = Tag::whereIn('id', $trendy_topics->tag_ids)->orderByRaw("FIELD(id,$tagIdsString)")->get();
       }
       return TagResource::collection($tags);
    }

    public function trendingTopicStories(Request $request,Tag $tag){
         $pageSize = $request->input('size', 20);
         $stories = $tag->stories()->orderBy('id', 'desc')->paginate($pageSize); 

        return StoryResource::collection($stories);
    }

    public function relatedStories(Request $request){
         $tagIds = explode(',', $request->input('tags', ''));
         $pageSize = $request->input('size', 20);
  
         if (empty($tagIds) || $tagIds[0] === '') {
             return response()->json([
                 'success' => false,
                 'message' => 'No tag IDs provided'
             ], 400);
         }
  
         $stories = Story::whereHas('tags', function ($query) use ($tagIds) {
             $query->whereIn('id', $tagIds);
         })->orderBy('id', 'desc')->paginate($pageSize);
  
         return StoryResource::collection($stories);
    }
}
