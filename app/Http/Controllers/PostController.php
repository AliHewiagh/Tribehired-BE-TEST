<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Collection;

class PostController extends Controller
{


    protected $CommentController;
    public function __construct(CommentController $CommentController)
    {
        $this->CommentController = $CommentController;
    }


    /**
     * Get all comments from CommentController
     *
     * Received comments grouped by postId
     */
    public function getComments() {

        $comments = $this->CommentController->index();
        return $comments;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get all posts from the external api
        $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->collect();


        // Get all comments from CommentController
        $comments = $this->getComments();

        // Structure post and get number of comments of the post
        $modified_posts = $posts->map(function ($item) use ($comments){
             return [
                'id'                       => $item['id'],
                'post_title'               => $item['title'],
                'post_body'                => $item['body'],
                'total_number_of_comments' => count($comments[$item['id']])
            ];
        });


        // Sort posts(descending order) by total number of the comments.
        $topPosts = $modified_posts->sortByDesc('total_number_of_comments');


        return $topPosts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
