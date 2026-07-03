<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:documents,slug'],
            'description' => ['nullable', 'string', 'max:500'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:20480'],
            'category' => ['required', 'in:academic,administrative,regulation,form,other'],
            'status' => ['required', 'in:draft,published,archived'],
        ];
    }
}
