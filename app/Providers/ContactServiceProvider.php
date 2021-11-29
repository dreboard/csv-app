<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterface;
use App\Models\Contact;
use App\Observers\ContactObserver;
use App\Repositories\ContactsRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, ContactsRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::model('contacts', Contact::class);
        Contact::observe(ContactObserver::class);
    }
}
