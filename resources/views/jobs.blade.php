<h1>{{$heading}}</h1>

@unless (count($jobs) == 0)

@foreach ($jobs as $job)
    <h2>
        <a href="/jobs/{{$job->id}}">{{$job->title}}</a>
    </h2>
    <p>{{$job->description}}</p>
@endforeach
    
@endunless