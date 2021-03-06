<?php namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Guard;

class OrganizationRequest extends Request
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
        return [
            'name' => 'required|max:255|unique:organizations,name,' . $this->id,
            'phone' => array("regex:/^\+?[0-9]{10,20}$/im"),
            'email' => 'required|email|max:255|unique:organizations,email,' . $this->id,
            'website' => 'url|max:255',
            'address' => 'required|max:255',
            'status' => 'required|string|max:255',
            'owner_id' => 'required|integer',
            'siren_number' => array("regex:/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}$/im", 'unique:organizations,siren_number,' . $this->id,),
            'siret_number' => array('required', "regex:/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{5}$/im", 'unique:organizations,siret_number,' . $this->id,),
            'ape_number' => array('required', "regex:/(^[0-9]{1,2}\.[0-9]{1,2}[A-Z]$|^[0-9]{1,2}\.[0-9]{1,2})$/im"),
            'tva_number' => array('required', "regex:/^[A-Z]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}$/im"),
            'licence_id' => 'required|integer',
        ];
    }
}

