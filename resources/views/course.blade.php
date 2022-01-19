@extends('layouts.front')

@section('main')

    <h2>{{ $course->title }}</h2>

    <p>{{ $course->description }}</p>

    <p>
        @if (\Auth::check())
           <h3>Welcome !</h3>
        @else
            <a href="#"
               class="btn btn-primary">Buy course (${{ $course->price }})</a>
        @endif
    </p>


    @foreach ($course->publishedLessons as $lesson)
        @if ($lesson->free_lesson)(FREE!)@endif {{ $loop->iteration }}.
        <a href="{{ route('lessons.show', [$lesson->course_id, $lesson->slug]) }}">{{ $lesson->title }}</a>
        <p>{{ $lesson->short_text }}</p>
        <hr />
    @endforeach

@endsection