<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // show all jobs
    public function index()
    {
        return view('jobs.index', [
            'heading' => 'Latest Jobs',
            'jobs' => Job::all()
        ]);
    }

    // single job
    public function show($id)
    {
        return view('jobs.job', [
            'job' => Job::find($id)
        ]);
    }
}
