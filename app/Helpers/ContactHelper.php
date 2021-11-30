<?php

namespace App\Helpers;

use App\Models\BadContact;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class ContactHelper
{

    /**
     * @var array
     */
    private array $contactArray;

    /**
     * @var int
     */
    private int $batch;

    /**
     * @var string
     */
    private $invalidTxt = 'value was empty or invalid';

    /**
     * @var
     */
    private $source;


    /**
     * @param array $contactArray
     * @param int $batch
     * @param string $source
     */
    public function __construct(array $contactArray, int $batch, string $source)
    {
        $this->contactArray = $contactArray;
        $this->batch = $batch;
        $this->source = $source;
    }


    /**
     * Filter valid and invalid contacts from converted csv file
     *
     * @return bool
     */
    public function filterContact(): bool
    {
        if ($this->contactArray['first_name'] == '' ||
            $this->contactArray['last_name'] == '' ||
            $this->contactArray['email'] == '' ||
            false == $this->validEmail($this->contactArray['email']) ||
            false == $this->validPhone($this->contactArray['phone']) ||
            $this->contactArray['phone'] == '')
        {

            BadContact::create([
                'first_name' => $this->contactArray['first_name'],
                'last_name' => $this->contactArray['last_name'],
                'email' => $this->contactArray['email'],
                'phone_number' => $this->contactArray['phone'],
                'reason' => $this->invalidTxt,
                'source' => $this->source,
                'batch' => $this->batch,
            ]);

            return false;
        }
        $this->enterContact();
        return true;
    }


    /**
     * Create a contact
     *
     */
    public function enterContact()
    {
        Contact::create([
            'first_name' => $this->contactArray['first_name'],
            'last_name' => $this->contactArray['last_name'],
            'email' => $this->contactArray['email'],
            'phone_number' => $this->contactArray['phone'],
        ]);
    }


    /**
     * Validate an email address
     *
     * @param string $value
     * @return bool
     */
    private function validEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }


    /**
     * Validate a phone number
     *
     * @param string $value
     * @return bool
     */
    private function validPhone(string $value): bool
    {
        return preg_match('/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/m', $value );
    }


}
