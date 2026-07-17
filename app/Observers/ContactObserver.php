<?php

namespace App\Observers;

use App\Models\Contact;
use Illuminate\Support\Facades\Cache;

class ContactObserver
{
    public function created(Contact $contact): void
    {
        Cache::forget('dashboard_stats');
    }

    public function updated(Contact $contact): void
    {
        Cache::forget('dashboard_stats');
    }
}