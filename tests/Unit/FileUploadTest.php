<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{

    use WithoutMiddleware;

    private string $url = '/api/store';

    private string $testFile = 'contact.csv';


    /**
     * Test upload post validation.
     *
     * @return void
     */
    public function test_new_file_upload_validation()
    {
        $this->post($this->url, ['file' => ''])->assertSessionHasErrors('file');
    }


    /**
     * Test upload post route.
     *
     * @return void
     */
    function test_file_can_be_uploaded()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create(time().$this->testFile)
            ->storeAs('daily', time().$this->testFile);

        $response = $this->post($this->url, [
            'file' => $file,
        ]);
        Storage::disk('local')->assertExists($file);
        Storage::disk('local')->delete($file);
        Storage::disk('local')->assertMissing('contact.csv');
    }


}
