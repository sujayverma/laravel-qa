<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>
                        {{ $answersCount . " ". Str::plural('Answer', $answersCount) }}
                    </h2>
                </div>
                <hr>
                @include('layouts._message')

                @foreach ( $answers as $answer )
                    <div class="d-flex bd-highlight">
                        <div class="p-2 flex-grow-2 bd-highlight">
                            <div class="d-flex flex-column vote-controls">
                                <a title="This answer is usefull" 
                                class="vote-up {{ Auth::guest() ? 'off' : ''}}"
                                onclick="event.preventDefault(); document.getElementById('up-vote-answer-{{ $answer->id}}').submit()"
                                >
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form id="up-vote-answer-{{ $answer->id }}" method="POST" action="/answers/{{ $answer->id}}/vote " style="display: hidden">
                                    @csrf
                                  <input type="hidden" name="vote" value="1" />
                                </form>
                                <span class="votes-count"> {{ $answer->votes_count}}</span>
                                <a class="vote-down {{ Auth::guest() ? 'off' : ''}}" 
                                   title="This answer is not usefull"
                                   onclick="event.preventDefault(); document.getElementById('down-vote-answer-{{ $answer->id}}').submit()"
                                   >
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form id="down-vote-answer-{{ $answer->id }}" method="POST" action="/answers/{{ $answer->id}}/vote " style="display: hidden">
                                    @csrf
                                  <input type="hidden" name="vote" value="-1" />
                                </form>
                                @can('accept', $answer)
                                <a class="{{ $answer->status}} mt-2" 
                                    title="Mark this answer as best answer"
                                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();"
                                    >
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form id="accept-answer-{{ $answer->id }}" method="POST" action=" {{ route('answers.accept', $answer->id)}} " style="display: hidden">
                                    @csrf
                                </form>
                                @else
                                    @if ($answer->is_best)
                                    <a class="{{ $answer->status}} mt-2" title="The question owner accepted this as best answer" >
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                    @endif
                                @endcan
                            </div>
                            </div>
                        <div class="p-2 flex-grow-1 bd-highlight">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto" style="margin-left: auto">
                                        @can('update', $answer)
                                            <a href="{{ route('question.answers.edit', [$question->id, $answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan
                                        @can('delete', $answer)
                                            <form class="form-delete" method="POST" action=" {{ route('question.answers.destroy', [$question->id, $answer->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are You Sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    
                                    @include('shared._author', [
                                        'model' => $answer,
                                        'label' => 'Answered'
                                    ])
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