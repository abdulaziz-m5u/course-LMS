@extends('layouts.admin')

@section('content')

    <div class="title d-flex justify-content-between">
        <h3 class="page-title">Question Option</h3>
        @can('questions_option_create')
        <p >
            <a href="{{ route('admin.question_options.create') }}" class="btn btn-success">Add New</a>
            
        </p>
        @endcan
   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
            <li><a href="{{ route('admin.question_options.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">All</a></li> |
            <li><a href="{{ route('admin.question_options.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Trash</a></li>
        </ul>
    </p>

<div class="card">
    <div class="card-header">
    Question Option
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
                            Question
                        </th>
                        <th>
                            Option Text
                        </th>
                        <th>
                            Correct
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($question_options as $question_option)
                    <tr data-entry-id="{{ $question_option->id }}">
                        <td>
                        </td>
                        <td>{{ $question_option->question->question ?? '' }}</td>
                        <td>{!! $question_option->option_text !!}</td>
                        <td>{{ $question_option->correct == 1 ? 'true' : 'false' }}</td>
                        <td>
                        @if( request('show_deleted') == 1 )
                        <form action="{{ route('admin.question_options.restore', $question_option->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >Restore</button>
                        </form>
                        <form action="{{ route('admin.question_options.perma_del', $question_option->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{ route('admin.question_options.edit', $question_option->id) }}">
                                Edit
                            </a>
                            <form action="{{ route('admin.question_options.destroy', $question_option->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
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