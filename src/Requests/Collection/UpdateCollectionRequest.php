<?php

namespace SethSharp\BlogCrud\Requests\Collection;

use Illuminate\Validation\Rule;
use SethSharp\BlogCrud\Models\Blog\Blog;
use Illuminate\Foundation\Http\FormRequest;
use SethSharp\BlogCrud\Models\Blog\Collection;

class UpdateCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage', Collection::class);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:254',
                Rule::unique(Collection::class, 'title')->ignore($this->route('collection')->id),
            ],
            'description' => [
                'required',
                'string',
                'max:254',
            ],
            'blogs' => [
                'array',
                'nullable'
            ],
            'blogs.*.id' => [
                Rule::exists(Blog::class, 'id')
            ]
        ];
    }
}
