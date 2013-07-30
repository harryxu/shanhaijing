<?php namespace Shanhaijing\CpanelExt\Services\Validators;

use Stevemo\Cpanel\Services\Validators\ValidatorService;

// TODO extends Stevemo\Cpanel\Services\Validators\Users\Validator
class UserValidator extends ValidatorService {

    /**
     * User validation rules
     * @var array
     */
    public static $rules = array(
        'username'  => 'required',
        'email'      => 'required|email',
        'password'   => 'required|confirmed',
    );

    /**
     * Perform validation
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return Bool 
     */
    public function passes()
    {
        
        if ( isset($this->data['id']) ) 
        {
            /**
             *  if password and conf_pass are empty
             *  The user don't want to change is password
             *  so remove password rules
             */
            if( empty($this->data['password']) AND empty($this->data['password_confirmation']) )
            {
                unset(static::$rules['password']);
                unset($this->data['password']);
            }
        }

        $status = parent::passes();
        unset($this->data['password_confirmation']);
        return $status;
    }

}

