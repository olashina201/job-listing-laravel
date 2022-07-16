<h1>{{$heading}}</h1>

@unless (count($jobs) == 0)

@foreach ($jobs as $job)
    <h2>
        <a href="">{{$job->title}}</a>
    </h2>
@endforeach
    
@endunless