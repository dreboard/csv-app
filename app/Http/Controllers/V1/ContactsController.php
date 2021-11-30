<?php
/**
 * ContactsController class
 *
 * The class is empty for the sake of this example.
 *
 * @package    MyProject
 * @subpackage Common
 * @author     Moshe Teutsch <moteutsch@gmail.com>
 */
namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactsPostRequest;
use App\Http\Resources\ContactsResource;
use App\Models\Contact;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ContactsController extends Controller
{

    private $errorResponse = 'There was an error with your request';

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ContactsResource::collection(Contact::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ContactsPostRequest $request
     * @return ContactsResource
     */
    public function store(ContactsPostRequest $request): ContactsResource
    {
        $contact = Contact::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
        ]);

        return new ContactsResource($contact);
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return ContactsResource|JsonResponse
     */
    public function show(Contact $contact): ContactsResource|JsonResponse
    {
        try{
            return new ContactsResource($contact);;
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['data' => $this->errorResponse]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return ContactsResource|JsonResponse
     */
    public function update(Request $request): ContactsResource|JsonResponse
    {
        $contact = Contact::find($request->input('id'));

        try{
            $contact->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
            ]);

            return new ContactsResource($contact);

        } catch(Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'data' => $this->errorResponse,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return JsonResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);

    }
}
