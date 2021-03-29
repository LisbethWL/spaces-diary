<?php
/*Validation er indeholdt i Controllers*/
namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;



class PostController extends Controller
{   

    public function getIndex() {
        /* $posts = Post::all(); */
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('blog.index', ['posts' => $posts]);
    }

    public function getAdminIndex() {
        if (!Auth::check()) {
            return redirect()->back();
        }
        $posts = Post::orderBy('title', 'asc')->get();
        return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id) {
        $post = Post::where('id', $id)->with('likes')->first();
        return view('blog.post', ['post' => $post]);
    }

    public function getLikePost($id) {
        $post = Post::where('id', $id)->first();
        $like = new Like();
        $post->likes()->save($like);
        return redirect()->back();
    }

    public function getAdminCreate() {
        if (!Auth::check()) {
            return redirect()->back();
        }
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    public function getAdminEdit($id) {

        if (!Auth::check()) {
            return redirect()->back();
        }
        $post = Post::find($id);
        $tags = Tag::all();
        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);
    }


    public function postAdminCreate(Request $request) {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back();
        }
        
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $user->posts()->save($post);
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));

        return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));
    }


    public function getAdminDelete($id) {

        if (!Auth::check()) {
            return redirect()->back();
        }
        $post = Post::find($id);

        if (Gate::denies('update-post', $post)) {
            return redirect()->back();
        }

        $post->likes()->delete();
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.index')->with('info', 'Post deleted!');
    }


    public function postAdminUpdate(Request $request) {

        if (!Auth::check()) {
            return redirect()->back();
        }
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = Post::find($request->input('id'));


        if (Gate::denies('update-post', $post)) {
            return redirect()->back();
        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        /* $post->tags()->detach();
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags')); */
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));
        return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' .$request->input('title'));
    }
}

 /* dependency injection ved at bruge Session facade (Store), se www: Illuminate\Session\Store
    Ændringer i: postAdminCreate for Models and Migrations
    post - > save metoden gemmer det på dben
 */