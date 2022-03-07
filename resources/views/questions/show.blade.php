@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-126">
            <div class="card">
                <div class="card-body">
                <div class="card-title">
                    <div class="d-flex align-items-center" style="align-items: center">
                        <h2>{{$question->title}}</h2>
                        <div class="ml-auto" style="margin-left: auto">
                            <a href="{{ route('question.index')}}" class="btn btn-outline-secondary">Back to All Questions</a>
                        </div>
                    </div>
                    
                </div>
                <hr>
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">
                    <div class="d-flex flex-column vote-controls">
                        <a title="This question is usefull" class="vote-up">
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>
                        <span class="votes-count">200</span>
                        <a class="vote-down off" title="This question is not usefull">
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>
                        <a class="favorite mt-2 favorited" title="Click to mark as favorite Question (Click again to undo)" >
                            <i class="fas fa-star fa-2x"></i>
                            <span class="favorites-count">123</span>
                        </a>
                    </div>
                    </div>
                   <div class="p-2 flex-grow-2 bd-highlight"> 
                        {!! $question->body_html !!}
                        <div class="float-end">
                            <span class="text-muted">{{ $question->created_date}}</span>
                            <div class="media mt-2">
                                <a href=" {{ $question->user->url }} " class="pr-2">
                                    <img src=" {{ $question->user->avatar }}" />
                                </a>
                                <div class="media-body">
                                    <a href=" {{ $question->user->url }} ">
                                        {{ $question->user->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @include('answers._index', [
        'answers' => $question->answers,
        'answersCount' => $question->answers_count
    ])
    @include('answers._create')
</div>
@endsection
