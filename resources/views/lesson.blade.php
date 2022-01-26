@extends('layouts.front')

@section('sidebar')
    <p class="lead">{{ $lesson->course->title }}</p>

    <div class="list-group">
        @foreach ($lesson->course->publishedLessons as $list_lesson)
            @if($list_lesson->free_lesson)
            <a href="{{ route('lessons.show', [$list_lesson->course_id, $list_lesson->slug]) }}" class="list-group-item"
                @if ($list_lesson->id == $lesson->id) style="font-weight: bold" @endif>{{ $loop->iteration }}. {{ $list_lesson->title }}</a>
            @else
                @if($purchased_course)
                    <a href="{{ route('lessons.show', [$list_lesson->course_id, $list_lesson->slug]) }}" class="list-group-item"
                    @if ($list_lesson->id == $lesson->id) style="font-weight: bold" @endif>{{ $loop->iteration }}. {{ $list_lesson->title }}</a>
                @else
                    <a onClick="return alert('You have to purchase the course !')" href="#" class="list-group-item"
                    @if ($list_lesson->id == $lesson->id) style="font-weight: bold" @endif>{{ $loop->iteration }}. {{ $list_lesson->title }}</a>
                @endif
            @endif
        @endforeach
    </div>
@endsection

@section('main')

    <h2>{{ $lesson->title }}</h2>
        <iframe width="420" height="315" class="mb-5" src="https://www.youtube.com/embed/{{ $lesson->embed_id }}">
        </iframe>
        {!! $lesson->full_text !!} 
    @if ($purchased_course)
        @if ($test_exists)
            <hr />
            <h3>Test: {{ $lesson->test->title }}</h3>
            @if (!is_null($test_result))
                <div class="alert alert-info">Your test score: {{ $test_result->test_result }}</div>
            @else
            <form action="{{ route('lessons.test', [$lesson->slug]) }}" method="post">
                @csrf
                @foreach ($lesson->test->questions as $question)
                    <b>{{ $loop->iteration }}. {{ $question->question }}</b>
                    <br />
                    @foreach ($question->options as $option)
                        <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}" /> {{ $option->option_text }}<br />
                    @endforeach
                    <br />
                @endforeach
                <input type="submit" value=" Submit results " />
            </form>
            @endif
            <hr />
        @endif
    @else
        Please <a href="{{ route('courses.show', [$lesson->course->slug]) }}">go back</a> and buy the course.
    @endif

    @if($purchased_course)
        @if ($previous_lesson)
        <p><a href="{{ route('lessons.show', [$previous_lesson->course_id, $previous_lesson->slug]) }}"><< {{ $previous_lesson->title }}</a></p>
        @endif
        @if ($next_lesson)
        <p><a href="{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->slug]) }}">{{ $next_lesson->title }} >></a></p>
        @endif
    @endif

@endsection