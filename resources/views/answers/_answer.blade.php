<answer :answer="{{ $answer }}" inline-template>
    <div class="d-flex bd-highlight post">
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
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10"></textarea>
                </div>
                <div class="mt-3">
                    <button  type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                    <button @click = "editing = false" class="btn btn-lg btn-outline-warning">Cancel</button>
                </div>
            </form>
            <div v-else>
            <div v-html="bodyHtml"></div>
            {{-- {!! $answer->body_html !!} --}}
            <div class="row">
                <div class="col-4">
                    <div class="ml-auto" style="margin-left: auto">
                        @can('update', $answer)
                            <a @click.prevent="editing = true" class="btn btn-sm btn-outline-info">Edit</a>
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
                    
                    {{-- @include('shared._author', [
                        'model' => $answer,
                        'label' => 'Answered'
                    ]) --}}
                    <user-info :model="{{ $answer }}" label="Answered by"></user-info>
                </div>
            </div>
            </div>
        </div>
    </div>
    
</answer> 
<div style="clear:both"></div>