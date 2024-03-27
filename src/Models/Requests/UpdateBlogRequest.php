<?php

namespace SethSharp\BlogCrud\Models\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SethSharp\BlogCrud\Models\Blog\Blog;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', [Blog::class, $this->route('blog')]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                Rule::unique(Blog::class, 'title')->ignore($this->route('blog')->id),
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique(Blog::class, 'slug')->ignore($this->route('blog')->id),
            ],
            'tags' => [
                'array',
                'exclude'
            ],
            'meta_title' => [
                'nullable',
                'string',
            ],
            'meta_tags' => [
                'nullable',
                'string',
            ],
            'meta_description' => [
                'nullable',
                'string',
            ],
            'content' => [
                'required',
                'string',
            ],
            'is_draft' => [
                'required',
                'boolean'
            ]
        ];
    }
}
