<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    // show all jobs
    public function index()
    {
        return view('jobs.index', [
            'heading' => 'Latest Jobs',
            'jobs' => Job::latest()->filter(request(['tag', 'search']))->paginate(5)
        ]);
    }

    // single job
    public function show($id)
    {
        return view('jobs.job', [
            'job' => Job::find($id)
        ]);
    }

    // Create job
    public function create()
    {
        return view('jobs.create');
    }

    // Store job
    public function store(Request $req)
    {
        $fields = $req->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('jobs', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($req->hasFile('logo')) {
            $fields['logo'] = $req->file('logo')->store('logos', 'public');
        }

        Job::create($fields);

        return redirect('/')->with('message', 'Job Created Successfully');
    }
}
