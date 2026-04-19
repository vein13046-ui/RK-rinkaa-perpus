<?php

use App\Models\BorrowRequest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    BorrowRequest::expireOverduePickups();
})->everyMinute();

Schedule::command('borrow:history-cleanup')->hourly();
