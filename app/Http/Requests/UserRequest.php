<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

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
                    'preferred_username' => 'required|max:255|unique:users,preferred_username',
                    'family_name' => 'required|max:255',
                    'given_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                ];
            }
            case 'PATCH': {
                $user = $this->auth->user();
                return [
                    'preferred_username' => 'required|max:255|unique:users,preferred_username,' . $user->id,
                    'family_name' => 'required|max:255',
                    'given_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                ];
            }
        }
    }
}
