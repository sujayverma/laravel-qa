@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-126">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="align-items: center">
                        <h2>All Questions</h2>
                        @if(Auth::user())
                        <div class="ml-auto" style="margin-left: auto">
                            <a href="{{ route('question.create')}}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>
                        @endif
                    </div>
                    
                </div>

                <div class="card-body">
                    @include('layouts._message')
                    @foreach ( $questions as $question )
                    <div class="d-flex">
                        <div class="flex-shrink-0 flex-column counters">
                            <div class="vote">
                                <strong> {{$question->votes_count}}</strong> {{ Str::plural('vote',$question->votes_count)}}
                            </div>
                            <div class="status {{ $question->status }}">
                                <strong> {{$question->answers_count}}</strong> {{ Str::plural('answer',$question->answers_count)}}
                            </div>
                            <div class="view">
                                 {{$question->views." ". Str::plural('view',$question->views)}}
                            </div>
                        </div> 
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center" style="align-items: center">
                                <h3 class="mt-0"><a href="{{ $question->url }}"> {{ $question->title }} </a></h3>
                                <div class="ml-auto" style="margin-left: auto">
                                    @can('update', $question)
                                        <a href="{{ route('question.edit', $question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                                    @endcan
                                    @can('delete', $question)
                                        <form class="form-delete" method="POST" action=" {{ route('question.destroy', $question->id) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure?')">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                            <p class="lead">
                                Asked by <a href="{{$question->user->url}}"> {{$question->user->name}}</a>
                                <small class="text-muted"> {{$question->created_date}}</small>
                            </p>    
                            {{ Str::limit( $question->body, 250 ) }}
                        </div>
                    </div>   
                    <hr/> 
                    @endforeach
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
