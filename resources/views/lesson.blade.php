@extends('layouts.front')

@section('content')
<section class="detail section" id="detail">
        <div class="detail-container grid" style="row-gap: 5rem">
          <div class="watch-data-left" id="watch-data-left">
            <iframe src="https://www.youtube.com/embed/{{ $lesson->embed_id }}"> </iframe>
        @if($purchased_course)
            @if ($previous_lesson)
            <div
              class="swiper-button-prev watch-prev-icon"
              style="
                left: 10px;
                right: initial;
                bottom: 0px;
                border-radius: 50%;
              "
            >
              <a href="{{ route('lessons.show', [$previous_lesson->course_id, $previous_lesson->slug]) }}"> <i class="bx bx-left-arrow-alt"></i></a>
            </div>
          @endif
          @if ($next_lesson)
            <div
              class="swiper-button-next watch-next-icon"
              style="
                right: 10px;
                left: initial;
                bottom: 0px;
                border-radius: 50%;
              "
            >
              <a href="{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->slug]) }}"><i class="bx bx-right-arrow-alt"></i></a>
            </div>
          @endif
        @endif
            <div
              class="swiper-button-next watch-next-icon"
              id="fullscreen"
              style="right: 50%; left: initial; bottom: 0px; border-radius: 50%"
            >
              <i class="bx bx-fullscreen"></i>
            </div>
          </div>
          <div class="watch-data-right" id="watch-data-right">
            <ul style="padding-bottom: 5rem;">
            @foreach ($lesson->course->publishedLessons as $publishedLesson)
                @if ($publishedLesson->free_lesson)
                    <li>
                        <a href="{{ route('lessons.show', [$publishedLesson->course_id, $publishedLesson->slug]) }}"><i class="bx bx-play-circle"></i>{{ $publishedLesson->title }}</a>
                    </li>
                @else
                  @if($purchased_course)
                    <li>
                        <a href="{{ route('lessons.show', [$publishedLesson->course_id, $publishedLesson->slug]) }}"><i class="bx bx-play-circle"></i>{{ $publishedLesson->title }}</a>
                    </li>
                  @endif
                @endif
            @endforeach
            </ul>
            @if(!$purchased_course)
                @if (auth()->check())
                    @if ($lesson->course->students()->where('user_id', auth()->id())->count() == 0)
                        <form action="{{ route('courses.payment') }}" style="margin-top: 1rem;" method="POST">
                        @csrf
                            <input type="hidden" name="course_id" value="{{ $lesson->course->id }}" />
                            <input type="hidden" name="amount" value="{{ $lesson->course->price }}" />
                            <input type="hidden" name="lesson_id" value="{{   $lesson->course->publishedLessons[0]->slug }}" />
                            <button class="button detail-button">Purchase Course</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('register') }}?redirect_url={{ route('courses.show', [$lesson->course->slug]) }}"
                    class="button detail-button" style="text-align: center;">Purchase Course (${{ $lesson->course->price }})</a>
                @endif
            @endif
          </div>
        </div>
      </section>

      <section class="section question">
        <div class="question-data">
        @if ($purchased_course)
          @if ($test_exists)
            @if (!is_null($test_result))
                  <div class="alert alert-info">Your test score: {{ $test_result->test_result }}</div>
            @else
            <form action="{{ route('lessons.test', [$lesson->slug]) }}" method="post">
            @csrf
              @foreach ($lesson->test->questions as $question)
                <h3 for="question" style="margin-bottom: 1.2rem">
                {{ $loop->iteration }}. {{ $question->question }}
                </h3>

                @foreach ($question->options as $option)
                  <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}" style="margin-bottom: 0.8rem" /> {{ $option->option_text }}
                  <br />
                @endforeach
              @endforeach

              <button class="button" 
                style="border: none; padding: 0.4rem 1.4rem; border-radius: 1rem;margin-top: 1rem;" >Submit Result</button>
            </form>
            @endif
          @endif
        @endif
        </div>
      </section>

      @if ($purchased_course)
      <section class="section rating">
        <div class="rating-data">
          <h4>Rating: {{ $lesson->course->rating }} / 5</h4>
          <small>Rate the course:</small>
          <form
            style="
              margin-top: 1rem;
              display: flex;
              align-items: center;
              column-gap: 1rem;
            "
             action="{{ route('courses.rating', [$lesson->course->id]) }}" method="post"
            method="post"
          >
          @csrf
            <select
              name="rating"
              style="
                height: 30px;
                min-width: 30%;
                border: none;
                background-color: #e2e2e2;
                border-radius: 0.8rem;
                outline: none;
              "
            >
              <option value="1">1 - Awful</option>
              <option value="2">2 - Not too good</option>
              <option value="3">3 - Average</option>
              <option value="4" selected>4 - Quite good</option>
              <option value="5">5 - Awesome!</option>
            </select>
            <button
              class="button"
              style="border: none; padding: 0.4rem 1.4rem; border-radius: 1rem"
            >Submit</button>
          </form>
        </div>

        @if (session('success')) 
        <div class="alert alert-info" id="alert" style="margin-top: 1rem;display:flex;justify-content: space-between">
           {{ session('success') }} <i class='bx bx-x' style="cursor:pointer;" id="close-alert"></i>
        </div>
        @endif
      </section>
      @endif

@endsection