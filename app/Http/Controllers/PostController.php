<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Collection;

class PostController extends Controller
{


    protected $commentController;


    public function __construct(CommentController $commentController)
    {
        $this->commentController = $commentController;
    }


    /**
     * Get all comments from CommentController
     *
     */
    public function getComments() {

        $comments = $this->commentController->index();
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
        // Group comments by postId
        $comments = $this->getComments()->groupBy('postId');


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
}
