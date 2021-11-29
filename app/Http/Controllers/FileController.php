<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Interfaces\RepositoryInterface;
use App\Repositories\ArrayRepository;
use Illuminate\Support\Facades\Log;
use Throwable;

class FileController extends Controller
{

    /**
     * @var RepositoryInterface
     */
    private ArrayRepository|RepositoryInterface $arrayRepository;

    private string $failMsg = 'File could not be uploaded';

    private string $successMsg = 'File uploaded and processing';


    public function __construct(ArrayRepository $arrayRepository)
    {
        $this->arrayRepository = $arrayRepository;
    }


    /**
     * Store a newly created file in storage and process.
     *
     * @param FileRequest $request
     * @return \Illuminate\Http\JsonResponse
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
