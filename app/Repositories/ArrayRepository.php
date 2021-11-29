<?php

namespace App\Repositories;

use App\Helpers\ContactArrayHelper;
use App\Helpers\ContactHelper;
use App\Interfaces\RepositoryInterface;
use App\Jobs\CSVImportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArrayRepository implements RepositoryInterface
{


    public function processFile(Request $request)
    {
        $file = $request->file('file')->storeAs('app/daily', 'dealer1_' . time());
        CSVImportJob::dispatch($file, 'dealer1');
    }

    /**
     * @param array $array
     * @param $source
     */
    public function processContactsArray(array $array, $source)
    {
        $batch = time();
        foreach ($array as $a){
            $processed = new ContactHelper($a, $batch, $source);
            $processed->filterContact();
            unset($processed);
        }

    }
}
