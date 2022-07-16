<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('jobs', [
        'heading' => 'Latest Jobs',
        'jobs' => Job::all()
    ]);
});

Route::get('/jobs/{id}', function ($id) {
    return view('job', [
        'job' => Job::find($id)
    ]);
});
