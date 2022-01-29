@extends('layouts.front')

@section('content')

    <section class="detail section" id="detail">
        <div class="detail-container grid">
          <div class="detail-data-left">
            <img src="{{ Storage::url($course->course_image) }}" alt="" />
            <h3>{{ $course->title }}</h3>
            <p>
                {{ $course->description }}
            </p>
          </div>
          <div class="detail-data-right">
            <ul>
            @foreach ($course->publishedLessons->take(3) as $lesson)
              <li>
                 @if ($lesson->free_lesson)
                    <a class="lesson-title" href="{{ route('lessons.show', [$lesson->course_id, $lesson->slug]) }}"><i class="bx bx-play-circle"></i>{{ $lesson->title }}</a>
                @else   
                  @if (!$purchased_course)
                    <a class="lesson-title" aria-disabled="false" style="cursor:  alias" href="#"><i class='bx bx-lock'></i>Another course {{ $lesson->count() }}</a>
                  @else  
                    <a class="lesson-title" href="{{ route('lessons.show', [$lesson->course_id, $lesson->slug]) }}"><i class="bx bx-play-circle"></i>{{ $lesson->title }}</a>
                  @endif
                @endif 
            </li>
             @endforeach
            </ul>
            @if (auth()->check())
                @if ($course->students()->where('user_id', auth()->id())->count() == 0)
                    <form action="{{ route('courses.payment') }}" method="POST">
                    @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}" />
                        <input type="hidden" name="amount" value="{{ $course->price }}" />
                        <input type="hidden" name="lesson_id" value="{{   $course->publishedLessons[0]->slug }}" />
                        <button class="button detail-button">Purchase Course</button>
                    </form>
                @endif
            @else
                <a href="{{ route('register') }}?redirect_url={{ route('courses.show', [$course->slug]) }}"
                class="button detail-button" style="text-align: center;">Buy course (${{ $course->price }})</a>
            @endif
          </div>
        </div>
      </section>

@endsection