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
                    </div>
                    <div style="clear:both"></div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>