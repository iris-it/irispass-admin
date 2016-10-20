<?php namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Validation\Rule;

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

        switch ($this->method()) {
            case 'POST': {
                return [
                    'name' => 'required|max:255',
                    'address' => 'required|max:255',
                    'address_comp' => 'max:255',
                    'phone' => 'required|min:10',
                    'email' => 'email|max:255',
                    'website' => 'max:500',
                    'status' => 'required|string|max:255',
                    'siren_number' => array("regex:/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}$/im", Rule::unique('organizations')),
                    'siret_number' => array('required', "regex:/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{5}$/im", Rule::unique('organizations')),
                    'ape_number' => array('required', "regex:/(^[0-9]{1,2}\.[0-9]{1,2}[A-Z]$|^[0-9]{1,2}\.[0-9]{1,2})$/im"),
                    'tva_number' => array('required', "regex:/^[A-Z]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}$/im"),
                ];
            }
            case 'PATCH': {
                $organization = $this->user()->organization;
                return [
                    'name' => 'required|max:255',
                    'address' => 'required|max:255',
                    'address_comp' => 'max:255',
                    'phone' => 'required|min:10',
                    'email' => 'email|max:255',
                    'website' => 'max:500',
                    'status' => 'required|string|max:255',
                    'siren_number' => array("regex:/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}$/im", Rule::unique('organizations')->ignore($organization->id)),
                    'siret_number' => array('required', "regex:/^[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{5}$/im", Rule::unique('organizations')->ignore($organization->id)),
                    'ape_number' => array('required', "regex:/(^[0-9]{1,2}\.[0-9]{1,2}[A-Z]$|^[0-9]{1,2}\.[0-9]{1,2})$/im"),
                    'tva_number' => array('required', "regex:/^[A-Z]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}[ \.\-]?[0-9]{3}$/im"),
                ];
            }
        }
    }
}
