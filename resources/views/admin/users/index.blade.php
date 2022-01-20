@extends('layouts.admin')

@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                Add Users
            </a>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        User
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
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Role
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($users as $user)
                    <tr data-entry-id="{{ $user->id }}">
                        <td>
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            @foreach ($user->role as $singleRole)
                                <span class="badge badge-info">{{ $singleRole->title }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                            </form>
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