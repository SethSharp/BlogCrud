<?php

namespace SethSharp\BlogCrud\Requests\Blogs;

use Illuminate\Validation\Rule;
use App\Domain\Blog\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('store', Blog::class);
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file'
            ],
            'file_id' => [
                'nullable',
                'string'
            ],
            'blog_id' => [
                'required',
                'int',
                Rule::exists(Blog::class, 'id')
            ],
        ];
    }
}
