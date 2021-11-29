<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ContactImports implements ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, SkipsEmptyRows
{

    use Importable;
    use SkipsErrors;
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return Contact|null
     */
    public function model(array $row)
    {
        return new Contact([
            'first_name'     => $row['first_name'],
            'last_name'     => $row['last_name'],
            'email'    => $row['email'],
            'phone_number' => $row['phone'],
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        // TODO: Implement onFailure() method.
    }

    public function rules(): array
    {
        return [
            '*.email' => ['email', 'unique:contacts,email'],
            'first_name' => Rule::unique('contacts')->where(function ($query) {
                return $query
                    ->where('first_name', ':first_name')
                    ->where('last_name', ':last_name');
            })
        ];
    }
}
