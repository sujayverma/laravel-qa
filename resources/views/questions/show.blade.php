@extends('layouts.app')

@section('content')
<div class="container">
    <question :question=" {{ $question }} "></question>
    {{-- @include('answers._index', [
        'answers' => $question->answers,
        'answersCount' => $question->answers_count
    ]) --}}
    <answers :question="{{ $question }}"></answers>
    {{-- @can('canAnswer') --}}
    {{-- @include('answers._create') --}}
    {{-- @endcan --}}
    
</div>
@endsection
