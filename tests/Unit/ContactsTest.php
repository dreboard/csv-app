<?php

namespace Tests\Unit;

use App\Http\Resources\ContactsResource;
use App\Models\Contact;
use Carbon\Carbon;
use Database\Factories\ContactFactory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class ContactsTest extends TestCase
{

    use WithoutMiddleware;

    private int $knownUser = 1;

    private string $url = '/api/V1/contacts';

    private string $knownContactEmail ='dre.board@gmail.com';

    /**
     * Test email post validation.
     *
     * @return void
     */
    public function test_new_contact_first_name_validation()
    {
        $contact = ContactFactory::new()->make(['first_name' => ''])->toArray();
        $this->post($this->url, $contact)->assertSessionHasErrors('first_name');
    }

    /**
     * Test email post validation.
     *
     * @return void
     */
    public function test_new_contact_last_name_validation()
    {
        $contact = ContactFactory::new()->make(['last_name' => ''])->toArray();
        $this->post($this->url, $contact)->assertSessionHasErrors('last_name');
    }

    /**
     * Test email post validation.
     *
     * @return void
     */
    public function test_new_contact_email_validation()
    {
        $contact = ContactFactory::new()->make(['email' => ''])->toArray();
        $this->post($this->url, $contact)->assertSessionHasErrors('email');
    }

    /**
     * Test email post validation.
     *
     * @return void
     */
    public function test_known_contact_email_validation()
    {
        $this->withMiddleware();
        $contact = ContactFactory::new()->make(['email' => $this->knownContactEmail])->toArray();
        $this->post($this->url, $contact)->assertJsonValidationErrors('email');
    }

    /**
     * Test phone post validation.
     *
     * @return void
     */
    public function test_new_contact_phone_validation()
    {
        $contact = ContactFactory::new()->make(['phone_number' => '123-rrr-aw34'])->toArray();
        $this->post($this->url, $contact)->assertSessionHasErrors('phone_number');
    }

    /**
     * Test viewing a contact.
     *
     * @return void
     */
    public function test_show_contact()
    {
        $contact = Contact::find($this->knownUser);

        $this->getJson($this->url.'/1')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'type',
                        'attributes' => [
                            'first_name',
                            'last_name',
                            'email',
                            'phone_number',
                            'created',
                        ]
                    ]
                ]
            );
    }

    /**
     * Test creating a contact.
     *
     * @return void
     */
    public function test_contact_is_created_successfully() {

        $contact = ContactFactory::new()->make()->toArray();
        $this->json('post', $this->url, $contact)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'type',
                        'attributes' => [
                            'first_name',
                            'last_name',
                            'email',
                            'phone_number',
                            'created',
                        ]
                    ]
                ]
            );
        $this->assertDatabaseHas('contacts', $contact);
    }


    /**
     * Test deleting a contact.
     *
     * @return void
     */
    public function test_contact_is_destroyed() {

        $this->withMiddleware();
        $contact = ContactFactory::new()->create()->toArray();

        $this->json('delete', $this->url."/".$contact['id'])
            ->assertNoContent();
        $this->assertDatabaseMissing('contacts', $contact);
    }
}
