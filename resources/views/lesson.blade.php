@extends('layouts.front')

@section('sidebar')
    <p class="lead">{{ $lesson->course->title }}</p>

    <div class="list-group">
        @foreach ($lesson->course->publishedLessons as $list_lesson)
            <a href="{{ route('lessons.show', [$list_lesson->course_id, $list_lesson->slug]) }}" class="list-group-item"
                @if ($list_lesson->id == $lesson->id) style="font-weight: bold" @endif>{{ $loop->iteration }}. {{ $list_lesson->title }}</a>
        @endforeach
    </div>
@endsection

@section('main')

    <h2>{{ $lesson->title }}</h2>
        <iframe width="420" height="315" src="https://www.youtube.com/embed/{{ $lesson->embed_id }}">
        </iframe>
    @if ($lesson->free_lesson == 1)
        {!! $lesson->full_text !!} 
    @else
        Please <a href="{{ route('courses.show', [$lesson->course->slug]) }}">go back</a> and buy the course.
    @endif

    @if ($previous_lesson)
        <p><a href="{{ route('lessons.show', [$previous_lesson->course_id, $previous_lesson->slug]) }}"><< {{ $previous_lesson->title }}</a></p>
    @endif
    @if ($next_lesson)
        <p><a href="{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->slug]) }}">{{ $next_lesson->title }} >></a></p>
    @endif

@endsection