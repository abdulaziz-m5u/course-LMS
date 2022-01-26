@extends('layouts.front')

@section('main')

<h2>{{ $course->title }}</h2>

@if ($purchased_course)
    Rating: {{ $course->rating }} / 5
    <br />
    <b>Rate the course:</b>
    <br />
    <form action="{{ route('courses.rating', [$course->id]) }}" method="post">
        @csrf
        <select name="rating">
            <option value="1">1 - Awful</option>
            <option value="2">2 - Not too good</option>
            <option value="3">3 - Average</option>
            <option value="4" selected>4 - Quite good</option>
            <option value="5">5 - Awesome!</option>
        </select>
        <input type="submit" value="Rate" />
    </form>
    <hr />
@endif

<p>{{ $course->description }}</p>

<p>
    @if (auth()->check())
        @if ($course->students()->where('user_id', auth()->id())->count() == 0)
        <form action="{{ route('courses.payment') }}" method="POST">
        @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}" />
            <input type="hidden" name="amount" value="{{ $course->price * 100 }}" />
            <button>Purchase Course</button>
            <!-- <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ env('PUB_STRIPE_API_KEY') }}"
                data-amount="{{ $course->price * 100 }}"
                data-currency="usd"
                data-name="Quick LMS"
                data-label="Buy course (${{ $course->price }})"
                data-description="Course: {{ $course->title }}"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-zip-code="false">
            </script> -->
        </form>
        @endif
    @else
        <a href="{{ route('register') }}?redirect_url={{ route('courses.show', [$course->slug]) }}"
           class="btn btn-primary">Buy course (${{ $course->price }})</a>
    @endif
</p>


    @foreach ($course->publishedLessons as $lesson)
        @if ($lesson->free_lesson)(FREE!)
        {{ $loop->iteration }}.
            <a href="{{ route('lessons.show', [$lesson->course_id, $lesson->slug]) }}">{{ $lesson->title }}</a>
            <p>{{ $lesson->short_text }}</p>
            <hr />
        @else
            @if($purchased_course)
                {{ $loop->iteration }}.
                <a href="{{ route('lessons.show', [$lesson->course_id, $lesson->slug]) }}">{{ $lesson->title }}</a>
                <p>{{ $lesson->short_text }}</p>
                <hr />
            @else 
                {{ $loop->iteration }}.
                <a onClick="return alert('you have to purchase the course !')" href="#">{{ $lesson->title }}</a>
                <p>{{ $lesson->short_text }}</p>
                <hr />
            @endif
        @endif
    @endforeach

@endsection