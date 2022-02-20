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
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>
                            {{ $question->answers_count . " ". Str::plural('Answer', $question->answers_count) }}
                        </h2>
                    </div>
                    <hr>
                    @foreach ( $question->answers as $answer )
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <div class="d-flex flex-column vote-controls">
                                    <a title="This answer is usefull" class="vote-up">
                                        <i class="fas fa-caret-up fa-3x"></i>
                                    </a>
                                    <span class="votes-count">200</span>
                                    <a class="vote-down off" title="This answer is not usefull">
                                        <i class="fas fa-caret-down fa-3x"></i>
                                    </a>
                                    <a class="vote-accepted mt-2" title="Mark this answer as best answer" >
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                </div>
                                </div>
                            <div class="p-2 flex-grow-2 bd-highlight">
                                {!! $answer->body_html !!}

                                <div class="float-end">
                                    <span class="text-muted">{{ $answer->created_date}}</span>
                                    <div class="media mt-2">
                                        <a href=" {{ $answer->user->url }} " class="pr-2">
                                            <img src=" {{ $answer->user->avatar }}" />
                                        </a>
                                        <div class="media-body">
                                            <a href=" {{ $answer->user->url }} ">
                                                {{ $answer->user->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
