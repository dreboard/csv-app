<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactsResource;
use App\Interfaces\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchContactsController extends Controller
{

    /**
     * @var RepositoryInterface
     */
    private $contactsRepository;

    public function __construct(RepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }


    /**
     * Perform a date range search on contacts
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function dateRange(Request $request): AnonymousResourceCollection
    {
        $contacts = $this->contactsRepository->findByDateRange($request);
        return ContactsResource::collection($contacts);
    }
}
