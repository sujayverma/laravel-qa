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
                    <div class="p-2 flex-grow-2 bd-highlight">
                    {{-- <div class="d-flex flex-column vote-controls">
                        <a title="This question is usefull" 
                        class="vote-up {{ Auth::guest() ? 'off' : ''}}"
                        onclick="event.preventDefault(); document.getElementById('up-vote-question-{{ $question->id}}').submit()"
                        >
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>
                        <form id="up-vote-question-{{ $question->id }}" method="POST" action="/question/{{ $question->id}}/vote " style="display: hidden">
                            @csrf
                          <input type="hidden" name="vote" value="1" />
                        </form>
                        <span class="votes-count"> {{$question->votes_count}} </span>
                        <a class="vote-down {{ Auth::guest() ? 'off' : ''}}" 
                           title="This question is not usefull"
                           onclick="event.preventDefault(); document.getElementById('down-vote-question-{{ $question->id}}').submit()"
                           >
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>
                        <form id="down-vote-question-{{ $question->id }}" method="POST" action="/question/{{ $question->id}}/vote " style="display: hidden">
                            @csrf
                          <input type="hidden" name="vote" value="-1" />
                        </form>
                       
                       <favorite :question="{{ $question }}"></favorite>
                        {{-- <form id="favorite-question-{{ $question->id }}" method="POST" action="/question/{{ $question->id}}/favorites " style="display: hidden">
                            @csrf
                            @if($question->is_favorited)
                                @method('DELETE')
                            @endif
                        </form> 
                    </div> --}}
                    <vote :model="{{ $question }}" name="question"></vote>
                    </div>
                   <div class="p-2 flex-grow-1 bd-highlight"> 
                        {!! $question->body_html !!}
                       
                            {{-- <div class="col-4">
                            </div>
                            <div class="col-4">
                            </div> --}}
                            <div class="float-end">
                                {{-- @include('shared._author', [
                                    'model' => $question,
                                    'label' => 'Asked'                                
                                    ]) --}}
                                    {{-- {{ json_encode($question)}} --}}
                                <user-info :model="{{ $question }}" label="Asked by"></user-info>

                            </div>
                        
                   </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('answers._index', [
        'answers' => $question->answers,
        'answersCount' => $question->answers_count
    ]) --}}
    <answers :question="{{ $question }}"></answers>
    {{-- @can('canAnswer') --}}
    @include('answers._create')
    {{-- @endcan --}}
    
</div>
@endsection
