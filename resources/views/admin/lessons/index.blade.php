@extends('layouts.admin')

@section('content')

    <div class="title d-flex justify-content-between">
        <h3 class="page-title">Lesson</h3>
        @can('lesson_create')
        <p >
            <a href="{{ route('admin.lessons.create') }}" class="btn btn-success">Add New</a>
            
        </p>
        @endcan
   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
            <li><a href="{{ route('admin.lessons.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">All</a></li> |
            <li><a href="{{ route('admin.lessons.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Trash</a></li>
        </ul>
    </p>

<div class="card">
    <div class="card-header">
    Lesson
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
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($lessons as $lesson)
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
                        @if( request('show_deleted') == 1 )
                        <form action="{{ route('admin.lessons.restore', $lesson->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >Restore</button>
                        </form>
                        <form action="{{ route('admin.lessons.perma_del', $lesson->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{ route('admin.lessons.edit', $lesson->id) }}">
                                Edit
                            </a>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="12">Data Not Found!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection