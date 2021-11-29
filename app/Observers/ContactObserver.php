<?php

namespace App\Observers;

use App\Models\Contact;


class ContactObserver
{

    /**
     * Check Contact table for existing values
     *
     * @param string $first
     * @param string $last
     * @param string $email
     * @return bool
     */
    private function checkContact(string $first, string $last, string $email): bool
    {
        $exists = Contact::where('first_name', '=', $first)
            ->where('last_name', '=', $last)
            ->oRwhere('email', '=', $email)
            ->first();
        if ($exists) {
            return false;
        }
        return true;
    }

    /**
     * Handle the Contact "created" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return mixed
     */

    public function creating(Contact $contact)
    {
        if (false === $this->checkContact($contact['first_name'], $contact['last_name'], $contact['email'])) {
            return false;
        }
        return true;
    }

    /**
     * Handle the Contact "saving" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return mixed
     */

    public function saving(Contact $contact)
    {
        if (false === $this->checkContact($contact['first_name'], $contact['last_name'], $contact['email'])) {
            return false;
        }
        return true;
    }


}
