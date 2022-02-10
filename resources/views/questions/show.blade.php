@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-126">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="align-items: center">
                        <h2>{{$question->title}}</h2>
                        <div class="ml-auto" style="margin-left: auto">
                            <a href="{{ route('question.index')}}" class="btn btn-outline-secondary">Back to All Questions</a>
                        </div>
                    </div>
                    
                </div>

                <div class="card-body">
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
                        <div class="media">
                            <div class="media-body">
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
