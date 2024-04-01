<?php

namespace SethSharp\BlogCrud\Requests\Tags;

use Illuminate\Validation\Rule;
use SethSharp\BlogCrud\Models\Blog\Tag;
use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('store', Tag::class);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique(Tag::class, 'name'),
            ],
        ];
    }
}
