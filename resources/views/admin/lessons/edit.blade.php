@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Lesson
    </div>

    <div class="card-body">
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('put')
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="course_id">Course*</label>
                    <select name="course_id" class="form-control" id="teacher" >
                        @foreach($courses as $id => $courseName)
                            <option {{ $id == $lesson->course_id ? "selected" : null }} value="{{ $id }}">{{ $courseName }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('title'))
                        <em class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </em>
                    @endif
                </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($lesson) ? $lesson->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="slug">Slug*</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($lesson) ? $lesson->slug : '') }}" required>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="full_text">Full Text*</label>
                <textarea id="desccription" name="full_text" rows="5" class="form-control" required>
                    {{ old('full_text', isset($lesson) ? $lesson->full_text : '') }}
                </textarea>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="short_text">short Text*</label>
                <textarea id="desccription" name="short_text" rows="5" class="form-control" required>
                    {{ old('short_text', isset($lesson) ? $lesson->short_text : '') }}
                </textarea>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="embed_id">Youtube URL*</label>
                <input type="text" id="embed_id" name="embed_id" class="form-control" value="{{ old('embed_id', isset($lesson) ? $lesson->embed_id : '') }}" required />
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="free_lesson">Free Lesson*</label>
                <select name="free_lesson" class="form-control" id="free_lesson">
                    <option {{ $lesson->free_lesson == 1 ? 'selected' : null }} value="1">Yes</option>
                    <option {{ $lesson->free_lesson == 0 ? 'selected' : null }} value="0">No</option>
                </select>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="published">Published*</label>
                <select name="published" class="form-control" id="published">
                    <option {{ $lesson->published == 1 ? 'selected' : null }} value="1">Active</option>
                    <option {{ $lesson->published == 0 ? 'selected' : null }} value="0">In Active</option>
                </select>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div>
                <button class="btn btn-danger" type="submit" >Save</button>
            </div>
        </form>
    </div>
</div>
@endsection