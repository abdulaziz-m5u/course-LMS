@extends('layouts.admin')

@section('content')

    <div class="title d-flex justify-content-between">
        <h3 class="page-title">Question</h3>
        @can('question_create')
        <p >
            <a href="{{ route('admin.questions.create') }}" class="btn btn-success">Add New</a>
            
        </p>
        @endcan
   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
            <li><a href="{{ route('admin.questions.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">All</a></li> |
            <li><a href="{{ route('admin.questions.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">Trash</a></li>
        </ul>
    </p>

<div class="card">
    <div class="card-header">
    Question
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
                            Question Image
                        </th>
                        <th>
                            Score
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($questions as $question)
                    <tr data-entry-id="{{ $question->id }}">
                        <td>
                        </td>
                        <td>
                            {{ $question->question }}
                        </td>
                        <td>
                        @if($question->question_image)<a href="{{ Storage::url($question->question_image) }}" target="_blank"><img src="{{  Storage::url($question->question_image) }}"/></a>@endif
                        </td>
                        <td>
                            {{ $question->score }}
                        </td>
                        <td>
                        @if( request('show_deleted') == 1 )
                        <form action="{{ route('admin.questions.restore', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >Restore</button>
                        </form>
                        <form action="{{ route('admin.questions.perma_del', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{ route('admin.questions.edit', $question->id) }}">
                                Edit
                            </a>
                            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
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