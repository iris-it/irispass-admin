<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends Request
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
        switch ($this->method()) {
            case 'POST': {
                return [
                    'family_name' => 'required|max:255',
                    'given_name' => 'required|max:255',
                    'preferred_username' => [
                        'required',
                        'max:255',
                        Rule::unique('users', 'preferred_username')
                    ],
                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users', 'email')
                    ],
                ];
            }
            case 'PATCH': {
                $user = $this->auth->user();
                return [
                    'family_name' => 'required|max:255',
                    'given_name' => 'required|max:255',
                    'preferred_username' => [
                        'required',
                        'max:255',
                        Rule::unique('users', 'preferred_username')->ignore($this->auth->id())
                    ],
                    'email' => [
                        'required',
                        'email',
                        'max:255',
                        Rule::unique('users', 'email')->ignore($this->auth->id())
                    ],
                ];
            }
        }
    }
}
