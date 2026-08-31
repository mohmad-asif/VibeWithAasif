<?php

namespace App\Data;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostData
{
    public int $user_id;
    public string $title;
    public string $category;
    public bool $is_active;
    public array $images = [];
    public array $keep_images = [];

    private function __construct(array $data)
    {
        $this->user_id = (int) ($data['user_id'] ?? Auth::id() ?? 1);
        $this->title = (string) $data['title'];
        $this->category = (string) $data['category'];
        $this->is_active = (bool) ($data['is_active'] ?? true);
        $this->images = is_array($data['images'] ?? null) ? $data['images'] : [];
        $this->keep_images = is_array($data['keep_images'] ?? null) ? $data['keep_images'] : [];
    }

    public static function fromRequest(Request $request, ?int $userId = null): self
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,avif|max:20480',
            'is_active' => 'nullable',
            'keep_images' => 'nullable|array',
            'keep_images.*' => 'nullable|integer',
        ]);

        $userId = $userId ?: (Auth::id() ?? 1);

        return new self([
            'user_id' => $userId,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'is_active' => $request->boolean('is_active', true),
            'images' => $request->file('images', []),
            'keep_images' => $request->input('keep_images', []),
        ]);
    }
}
