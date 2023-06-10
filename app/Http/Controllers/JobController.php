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
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('jobs', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        //store user id
        $formFields['user_id'] = auth()->user()->id;

        Job::create($formFields);

        return redirect('/')->with('message', 'Job Created Successfully');
    }

    public function edit($id) {
        return view('jobs.edit', [
            'job' => Job::find($id)
        ]);
    }

    // Update job
    public function update(Request $request, $id)
    {
        $listing = Job::find($id);

        // Make sure logged in user is owner
        if ($listing->user->id != auth()->user()->id) {
            abort(403, "Unauthorized Action");
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Job Edited Successfully');
    }

    public function destroy($id) {
        $job = Job::find($id);
        $job->delete();
        return redirect('/')->with('message', 'Job Deleted Successfully');
    }

    // Manage Listings
    public function manage()
    {
        return view("jobs.manage", [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
