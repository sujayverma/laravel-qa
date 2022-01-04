@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-126">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center" style="align-items: center">
                        <h2>Ask Question</h2>
                        <div class="ml-auto" style="margin-left: auto">
                            <a href="{{ route('question.index')}}" class="btn btn-outline-secondary">Back to All Questions</a>
                        </div>
                    </div>
                    
                </div>

                <div class="card-body">
                   <form action=" {{ route('question.store') }} " method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="question-title" class="form-label"> Question Title</label>
                            <input type="text" name="title" id="question-title" value=" {{ old('title') }}" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"  /> 
                            @if( $errors->has('title') )
                                <div class="invaild-feedback">
                                    <strong> {{ $errors->first('title') }} </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="question-body" class="form-label"> Explain your Question</label>
                            <textarea name="body" id="question-body" rows="10" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"> {{ old('body') }}</textarea>
                            @if( $errors->has('body') )
                                <div class="invaild-feedback">
                                    <strong> {{ $errors->first('body') }} </strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-lg btn-outline-primary">Ask This Question</button>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
