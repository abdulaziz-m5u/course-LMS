@extends('layouts.admin')

@section('content')

   <div class="title d-flex justify-content-between">
        <h3 class="page-title">Course</h3>
        @can('course_create')
        <p >
            <a href="{{ route('admin.courses.create') }}" class="btn btn-success">Add New</a>
            
        </p>
        @endcan
   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
            <li><a href="{{ route('admin.courses.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">All</a></li> |
            <li><a href="{{ route('admin.courses.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Trash</a></li>
        </ul>
    </p>
    
    <div class="card">
        <div class="card-header">
            Course
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                    <thead>
                        <tr>
                            <th width="10">
                                #
                            </th>
                            @if(auth()->user()->isAdmin())
                            <th>
                                Teacher Name
                            </th>
                            @endif
                            <th>
                                Title
                            </th>
                            <th>
                                Slug
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Course Image
                            </th>
                            <th>
                                Start Date
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
                    @forelse($courses as $key => $course)
                        <tr data-entry-id="{{ $course->id }}">
                            <td>

                            </td>
                            @if(auth()->user()->isAdmin())
                            <td>
                                @foreach ($course->teachers as $singleTeachers)
                                    <span class="badge badge-info">{{ $singleTeachers->name }}</span>
                                @endforeach
                            </td>
                            @endif
                            <td>
                                {{ $course->title ?? '' }}
                            </td>
                            <td>
                                {{ $course->slug ?? '' }}
                            </td>
                            <td>
                                {{ $course->description ?? '' }}
                            </td>
                            <td>
                                {{ $course->price ?? '' }}
                            </td>
                            <td>
                                <img width="150" src="{{ Storage::url($course->course_image) }}" alt="{{ $course->course_image }}">
                            </td>
                            <td>
                                {{ $course->start_date }}
                            </td>
                            <td>
                                {{ $course->published }}
                            </td>
                            <td>
                                @if( request('show_deleted') == 1 )
                                    <form action="{{ route('admin.courses.restore', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-info" >Restore</button>
                                    </form>
                                    <form action="{{ route('admin.courses.perma_del', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                                    </form>
                                @else 
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.courses.edit', $course->id) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="10">Not found !</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
</div>
@endsection