<?php

namespace App\Http\Requests;

use App\Rules\Virus;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShortLinkRequest
 *
 * @property string $link
 * @property boolean $state
 */
class ShortLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'link'  => ['required', 'url', new Virus],
            'state' => 'required|boolean',
        ];
    }
}
