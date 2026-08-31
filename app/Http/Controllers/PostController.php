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

        if (!empty($postData->images)) {
            foreach ($postData->images as $image) {
                if ($image && method_exists($image, 'isValid') && $image->isValid()) {
                    $this->storeImage($post->id, $image);
                }
            }
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

        if (!empty($postData->images)) {
            foreach ($postData->images as $image) {
                if ($image && method_exists($image, 'isValid') && $image->isValid()) {
                    $this->storeImage($post->id, $image);
                }
            }
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
        $status = $request->get('status', Auth::check() ? 'all' : 'active');

        try {
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
            if (Auth::check()) {
                $query->when($status === 'active', fn($q) => $q->where('is_active', true))
                    ->when($status === 'inactive', fn($q) => $q->where('is_active', false));
            }

            $posts = $query->latest()->paginate(6)->withQueryString();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Home query exception: ' . $e->getMessage());
            $posts = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 6);
        }

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
}
