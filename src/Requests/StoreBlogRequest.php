<?php

namespace SethSharp\BlogCrud\Requests;

use Illuminate\Validation\Rule;
use SethSharp\BlogCrud\Models\Blog\Blog;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('store', Blog::class);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                Rule::unique(Blog::class, 'title'),
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique(Blog::class, 'slug'),
            ],
            'tags' => [
                'array',
                'exclude',
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
