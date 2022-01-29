@extends('layouts.front')

@section('content')
    <section class="products section container" id="course">
        <h2 class="section-title">My Course</h2>

        <div class="featured-container grid">
            @forelse($purchased_courses as $purchased_course)
              <article class="products-card swiper-slide">
                <a style="color: inherit;" href="{{ route('courses.show', [$purchased_course->slug]) }}" class="products-link">
                    <img
                    src="{{ Storage::url($purchased_course->course_image) }}"
                    class="products-img"
                    alt=""
                    />
                    <h3 class="products-title">{{ $purchased_course->title }}</h3>
                    <div class="products-star">
                    @for ($star = 1; $star <= 5; $star++)
                        @if ($purchased_course->rating >= $star)
                        <i class="bx bxs-star"></i>
                        @else
                        <i class='bx bx-star'></i>
                        @endif
                    @endfor
                    </div>
                    <span class="products-price">${{ $purchased_course->price }}</span>
                    @if($purchased_course->students()->count() > 5)
                    <button class="products-button">
                        Popular
                    </button>
                    @endif
                    <span class="products-student">
                    {{ $purchased_course->students()->count() }} students
                    </span>
                </a>
              </article>
            @empty
                <h2 style="text-align: center;grid-column: 1/5">You haven't purchased course yet</h2>
            @endforelse
            </div>
      </section>

    <section class="products section container" id="course">
        <h2 class="section-title">All Course</h2>

        <div class="new-container">
          <div class="swiper new-swipper">
            <div class="swiper-wrapper">
            @foreach($courses as $course)
              <article class="products-card swiper-slide">
              <a style="color: inherit;" href="{{ route('courses.show', [$course->slug]) }}" class="products-link">
                <img
                  src="{{ Storage::url($course->course_image) }}"
                  class="products-img"
                  alt=""
                />
                <h3 class="products-title">{{ $course->title }}</h3>
                <div class="products-star">
                @for ($star = 1; $star <= 5; $star++)
                    @if ($course->rating >= $star)
                    <i class="bx bxs-star"></i>
                    @else
                    <i class='bx bx-star'></i>
                    @endif
                @endfor
                </div>
                <span class="products-price">${{ $course->price }}</span>
                @if($course->students()->count() > 5)
                  <button class="products-button">
                    Popular
                  </button>
                @endif
                <span class="products-student">
                {{ $course->students()->count() }} students
                </span>
              </a>
              </article>
            @endforeach
    
            </div>
            <div
              class="swiper-button-next"
              style="
                bottom: initial;
                top: 50%;
                right: 0;
                left: initial;
                border-radius: 50%;
              "
            >
              <i class="bx bx-right-arrow-alt"></i>
            </div>
            <div
              class="swiper-button-prev"
              style="bottom: initial; top: 50%; border-radius: 50%"
            >
              <i class="bx bx-left-arrow-alt"></i>
            </div>
          </div>
        </div>
      </section>
@endsection