<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\Contact;
use Illuminate\Http\Request;


/**
 *
 */
class ContactsRepository implements RepositoryInterface
{

    private $when = 'before';

    /**
     * Convert input to characters
     * @param string $when
     * @return string
     */
    private function convertWhen(string $when): string
    {
        if($when == $this->when){
            return '<=';
        }
        return '>=';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function findByDateRange(Request $request)
    {
        $request->validate([
            'when' => 'required|in:before,after',
            'searchDate' => 'date_format:Y-m-d'
        ]);

        return Contact::select('id', 'first_name', 'last_name', 'email', 'phone_number', 'created_at')
            ->whereDate('created_at', $this->convertWhen($request->input('when')), $request->input('searchDate'))
            ->get();
    }



}
