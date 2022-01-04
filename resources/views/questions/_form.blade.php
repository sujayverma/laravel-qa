@csrf
<div class="mb-3">
    <label for="question-title" class="form-label"> Question Title</label>
    <input type="text" name="title" id="question-title" value=" {{ old('title', $question->title) }}"
        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" />
    @if ($errors->has('title'))
        <div class="invaild-feedback">
            <strong> {{ $errors->first('title') }} </strong>
        </div>
    @endif
</div>
<div class="mb-3">
    <label for="question-body" class="form-label"> Explain your Question</label>
    <textarea name="body" id="question-body" rows="10"
        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"> {{ old('body', $question->body) }}</textarea>
    @if ($errors->has('body'))
        <div class="invaild-feedback">
            <strong> {{ $errors->first('body') }} </strong>
        </div>
    @endif
</div>
<div class="mb-3">
    <button type="submit" class="btn btn-lg btn-outline-primary">{{ $buttonText }}</button>
</div>
