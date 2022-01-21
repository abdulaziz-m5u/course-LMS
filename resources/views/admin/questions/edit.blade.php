@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Question
    </div>

    <div class="card-body">
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                <label for="question">question*</label>
                <textarea id="question" name="question" rows="5" class="form-control" required>
                    {{ old('question', isset($question) ? $question->question : '') }}
                </textarea>
                @if($errors->has('question'))
                    <em class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('question_image') ? 'has-error' : '' }}">
                <label for="question_image">Question Image*</label>
                <input type="file" id="question_image" name="question_image" class="form-control" />
                @if($errors->has('question_image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('question_image') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('score') ? 'has-error' : '' }}">
                <label for="score">Score*</label>
                <input type="number" id="score" name="score" class="form-control" value="{{ old('score', isset($question) ? $question->score : '') }}" required />
                @if($errors->has('score'))
                    <em class="invalid-feedback">
                        {{ $errors->first('score') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('test') ? 'has-error' : '' }}">
                <label for="test">Test*</label>
                <select name="test[]" class="form-control" id="test" multiple >
                    @foreach($tests as $id => $test)
                        <option {{ in_array($id, $question->tests->pluck('id')->toArray()) ? 'selected' : null }}  value="{{ $id }}">{{ $test }}</option>
                    @endforeach
                </select>
                @if($errors->has('test'))
                    <em class="invalid-feedback">
                        {{ $errors->first('test') }}
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