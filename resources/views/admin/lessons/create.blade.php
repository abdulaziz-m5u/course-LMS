@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Create Lesson
    </div>

    <div class="card-body">
        <form action="{{ route('admin.lessons.store') }}" method="POST">
            @csrf
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="course_id">Course*</label>
                    <select name="course_id" class="form-control" id="course_id" >
                        @foreach($courses as $id => $course)
                            <option value="{{ $id }}">{{ $course }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('course_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('course_id') }}
                        </em>
                    @endif
                </div>
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
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
                <textarea id="desccription" name="full_text" rows="5" class="form-control" value="{{ old('full_text', isset($lesson) ? $lesson->full_text : '') }}" required>
                </textarea>
                @if($errors->has('full_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('full_text') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('short_text') ? 'has-error' : '' }}">
                <label for="short_text">short Text*</label>
                <textarea id="desccription" name="short_text" rows="5" class="form-control" value="{{ old('short_text', isset($lesson) ? $lesson->short_text : '') }}" required>
                </textarea>
                @if($errors->has('short_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('short_text') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('embed_id') ? 'has-error' : '' }}">
                <label for="embed_id">Youtube URL*</label>
                <input type="text" id="embed_id" name="embed_id" class="form-control" value="{{ old('embed_id', isset($lesson) ? $lesson->embed_id : '') }}" required />
                @if($errors->has('embed_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('embed_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('free_lesson') ? 'has-error' : '' }}">
                <label for="free_lesson">Free Lesson*</label>
                <select name="free_lesson" class="form-control" id="free_lesson">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @if($errors->has('free_lesson'))
                    <em class="invalid-feedback">
                        {{ $errors->first('free_lesson') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
                <label for="published">Published*</label>
                <select name="published" class="form-control" id="published">
                    <option value="1">Active</option>
                    <option value="0">In Active</option>
                </select>
                @if($errors->has('published'))
                    <em class="invalid-feedback">
                        {{ $errors->first('published') }}
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