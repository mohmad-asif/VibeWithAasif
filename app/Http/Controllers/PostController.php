<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    private array $categories = ['Technology', 'Health', 'Business', 'Education', 'Sports'];

    public function createPage()
    {
        return view('posts.create', ['categories' => $this->categories]);
    }

    public function store(Request $request)
    {
        $postData = PostData::fromRequest($request, Auth::id());

        $post = Post::create([
            'user_id' => $postData->user_id,
            'title' => $postData->title,
            'category' => $postData->category,
            'is_active' => $postData->is_active,
        ]);

        foreach ($postData->images as $image) {
            $this->storeImage($post->id, $image);
        }

        return redirect()->route('home')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function editPage(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', [
            'post' => $post,
            'categories' => $this->categories,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $postData = PostData::fromRequest($request, Auth::id());

        if (empty($postData->keep_images) && empty($postData->images)) {
            return back()->withErrors(['images' => 'At least one image is required.']);
        }

        $post->update([
            'title' => $postData->title,
            'category' => $postData->category,
            'is_active' => $postData->is_active,
        ]);

        foreach ($post->images as $img) {
            if (!in_array($img->id, $postData->keep_images)) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        foreach ($postData->images as $image) {
            $this->storeImage($post->id, $image);
        }

        return redirect()->route('home')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        foreach ($post->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = PostImage::findOrFail($id);

        $this->authorize('delete', $image->post);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function home(Request $request)
    {
        $query = Post::with(['images' => fn($q) => $q->limit(1)]);

        // Guests only active
        if (!Auth::check()) {
            $query->where('is_active', true);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('category', 'like', "%{$request->search}%");
            });
        }

        // Status filter for logged-in users
        $status = $request->get('status', Auth::check() ? 'all' : 'active');

        if (Auth::check()) {
            $query->when($status === 'active', fn($q) => $q->where('is_active', true))
                ->when($status === 'inactive', fn($q) => $q->where('is_active', false));
        }

        $posts = $query->latest()->paginate(6)->withQueryString();

        return view('home', [
            'posts' => $posts,
            'status' => $status,
            'guest' => !Auth::check(),
        ]);
    }

    private function storeImage(int $postId, $image): void
    {
        $path = $image->store('posts', 'public');
        PostImage::create([
            'post_id' => $postId,
            'path' => $path,
        ]);
    }

    // public function index(Request $request)
    // {
    //     $query = Post::with(['images' => fn($q) => $q->limit(1)])->where('is_active', true);

    //     if ($request->filled('search')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('title', 'like', "%{$request->search}%")
    //                 ->orWhere('category', 'like', "%{$request->search}%");
    //         });
    //     }

    //     $posts = $query->latest()->paginate(6)->withQueryString();

    //     return view('home', [
    //         'posts' => $posts,
    //         'status' => 'active',
    //         'guest' => false,
    //     ]);
    // }

    // public function allPosts(Request $request)
    // {
    //     $query = Post::with(['images' => fn($q) => $q->limit(1)]);

    //     if ($request->filled('search')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('title', 'like', "%{$request->search}%")
    //                 ->orWhere('category', 'like', "%{$request->search}%");
    //         });
    //     }

    //     $status = $request->get('status', 'all');
    //     $query->when($status === 'active', fn($q) => $q->where('is_active', true))
    //         ->when($status === 'inactive', fn($q) => $q->where('is_active', false));

    //     $posts = $query->latest()->paginate(6)->withQueryString();

    //     return view('home', compact('posts', 'status'))->with('guest', false);
    // }

}
