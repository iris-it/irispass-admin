<?php namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Validation\Rule;

class GroupRequest extends Request
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => [
                'required',
                'max:255',
                Rule::unique('groups', 'name')->ignore($this->id)
            ]
        ];

        return $rules;
    }
}
