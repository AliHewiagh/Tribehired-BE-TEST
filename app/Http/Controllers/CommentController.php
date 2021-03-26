<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get comments from the external api
        $comments = Http::get('https://jsonplaceholder.typicode.com/comments')->collect();
        return $comments;
    }


    public function filter(Request $request) {

        // Get request parameters as array and convert to collection
        $query = collect($request->query());


         // Get all comments
        $comments = $this->index();


        if(count($comments) < 1) {
            return [];
        }

        // Get all comment field
        $felids = collect($comments[0])->keys();


        $filteredComments = collect();


        foreach ($felids as $felid) {
            if($query->has($felid)) {
                $filteredComments->push($comments->where($felid, $query[$felid]));
            }
        }

        return $filteredComments;
    }
}
