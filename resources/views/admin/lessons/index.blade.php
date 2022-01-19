@extends('layouts.admin')

@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.lessons.create') }}">
                Add lesson
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        lesson
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                <thead>
                    <tr>
                        <th width="10">
                            #
                        </th>
                        <th>
                            Course
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Position
                        </th>
                        <th>
                            Free Lesson
                        </th>
                        <th>
                            Published
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>

                @foreach($lessons as $lesson)
                    <tr data-entry-id="{{ $lesson->id }}">
                        <td>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $lesson->course->title }}</span>
                        </td>
                        <td>
                            {{ $lesson->title ?? '' }}
                        </td>
                        <td>
                            {{ $lesson->position }}
                        </td>
                        <td>
                            {{ $lesson->free_lesson ? 'Yes' : 'No' }}
                        </td>
                        <td>
                            {{ $lesson->published ? 'Active' : 'InActive' }}
                        </td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.lessons.edit', $lesson->id) }}">
                                Edit
                            </a>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection