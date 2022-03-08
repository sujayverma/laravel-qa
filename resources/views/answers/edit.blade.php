@extends('layouts.app')

@section('content')
<div class="container">
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Editing answer for question: <strong>{{ $question->title }}</strong></h3>
                </div>
                <hr>
                <form method="POST" action="{{ route('question.answers.update', [$question->id, $answer->id]) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <textarea name="body" rows="7" class="form-control @error('body') is-invalid @enderror "> {{ old('body', $answer->body) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-lg btn-outline-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection