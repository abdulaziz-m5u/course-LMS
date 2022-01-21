@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Create Test
    </div>

    <div class="card-body">
        <form action="{{ route('admin.tests.update', $test->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="course_id">Course*</label>
                <select name="course_id" class="form-control" id="teacher" >
                    @foreach($courses as $id => $course)
                        <option {{ $id == $test->course_id ? "selected" : null }}  value="{{ $id }}">{{ $course }}</option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('course_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="lesson_id">Lesson*</label>
                <select name="lesson_id" class="form-control" id="lesson_id" >
                    @foreach($lessons as $id => $lesson)
                        <option {{ $id == $test->lesson_id ? "selected" : null }} value="{{ $id }}">{{ $lesson }}</option>
                    @endforeach
                </select>
                @if($errors->has('lesson_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('lesson_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">title*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($test) ? $test->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">Description*</label>
                <textarea id="description" name="description" rows="5" class="form-control" required>
                    {{ old('description', isset($test) ? $test->description : '') }}
                </textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
                <label for="published">Published*</label>
                <select name="published" class="form-control" id="published">
                    <option {{ $test->published == 1 ? 'selected' : null }} value="1">Active</option>
                    <option {{ $test->published == 0 ? 'selected' : null }} value="0">In Active</option>
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