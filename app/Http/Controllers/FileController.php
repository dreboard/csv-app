<?php

namespace App\Http\Controllers;

use App\Helpers\ContactArrayHelper;
use App\Http\Requests\FileRequest;
use App\Imports\ContactImports;
use App\Interfaces\RepositoryInterface;
use App\Repositories\ArrayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class FileController extends Controller
{

    /**
     * @var RepositoryInterface
     */
    private $arrayRepository;

    private $failMsg = 'File could not be uploaded';

    private $successMsg = 'File uploaded and processing';


    public function __construct(ArrayRepository $arrayRepository)
    {
        $this->arrayRepository = $arrayRepository;
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,txt'
        ]);


        /* $file = $request->file('file')->storeAs('app/daily', 'dealer1_' . time());
         $array = ContactArrayHelper::csvToArray(Storage::path($file));
         $this->arrayRepository->processContactsArray($array, 'dealer1');*/

        //$file = $request->file('file');
        $file = $request->file('file')->storeAs('daily','dealer1_'.time());
        Excel::import(new ContactImports(), $file);
        return ["result" => $file];
    }


    /**
     * Store a newly created file in storage and process.
     *
     * @return
     */
    public function store(FileRequest $request)
    {
        try {
            $this->arrayRepository->processFile($request);

            return response()->json([
                'result' => $this->successMsg
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json([
                'result' => $this->failMsg
            ]);
        }
    }

}
