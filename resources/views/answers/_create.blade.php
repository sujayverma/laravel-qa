<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Your Answer</h3>
                </div>
                <hr>
                <form method="POST" action="{{ route('question.answers.store', $question->id) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="body" rows="7" class="form-control {{ $errors->has('body') ? 'is_invalid' : ''}} "></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>