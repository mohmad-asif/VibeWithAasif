<?php

namespace App\Data;

use Illuminate\Http\Request;

class PostData
{
    public int $user_id;
    public string $title;
    public string $category;
    public bool $is_active;
    public array $images;
    public array $keep_images;

    private function __construct(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->title = $data['title'];
        $this->category = $data['category'];
        $this->is_active = $data['is_active'];
        $this->images = $data['images'];
        $this->keep_images = $data['keep_images'] ?? [];
    }

    public static function fromRequest(Request $request, int $userId): self
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpg,jpeg,png',
            'is_active' => 'nullable|boolean',
            'keep_images' => 'array',
            'keep_images.*' => 'integer',
        ]);

        return new self([
            'user_id' => $userId,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'is_active' => $request->boolean('is_active'),
            'images' => $request->file('images', []),
            'keep_images' => $request->input('keep_images', []),
        ]);
    }
}
