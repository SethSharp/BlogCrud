<?php

namespace SethSharp\BlogCrud\Requests\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Models\Blog\Collection;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', [Blog::class, $this->route('blog')]);
    }

    public function rules(): array
    {
        return [
            'cover_image' => [
                'nullable',
                'image',
                'exclude'
            ],
            'title' => [
                'required',
                'string',
                'max:254',
                Rule::unique(Blog::class, 'title')->ignore($this->route('blog')->id),
            ],
            'collection_id' => [
                'nullable',
                'int',
                'exclude',
                Rule::exists(Collection::class, 'id')
            ],
            'slug' => [
                'nullable',
                'string',
                'min:10',
                'max:254',
                Rule::unique(Blog::class, 'slug')->ignore($this->route('blog')->id),
            ],
            'tags' => [
                'array',
                'exclude',
            ],
            'meta_title' => [
                'nullable',
                'required_if:is_draft,false',
                'string',
                'max:254',
            ],
            'meta_tags' => [
                'nullable',
                'required_if:is_draft,false',
                'string',
                'max:254',
            ],
            'meta_description' => [
                'nullable',
                'required_if:is_draft,false',
                'string',
                'max:254',
            ],
            'content' => [
                'required_if:is_draft,false',
                'string',
            ],
            'is_draft' => [
                'boolean',
                'exclude'
            ]
        ];
    }
}
