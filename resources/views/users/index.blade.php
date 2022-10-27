@extends('layouts.app')
@section('title')
    Users
@stop
@section('page-header-actions')
    <div class="d-flex">
        <a href="{{ route('user.create')  }}" class="btn btn-primary">
            @icon('plus')
            Add User
        </a>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            {{ __('Listing') }}
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class=" text-primary">
                <th>
                    {{ __('Name') }}
                </th>
                <th>
                    {{ __('Email') }}
                </th>
                <th>
                    {{ __('Creation date') }}
                </th>
                <th class="text-right">
                    {{ __('Actions') }}
                </th>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td class="td-actions text-right">
                            @if ($user->id != auth()->id())
                                <form action="{{ route('user.destroy', $user) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <a rel="tooltip" class="btn btn-sm  btn-outline-success "
                                       href="{{ route('user.edit', $user) }}" data-original-title=""
                                       title="">
                                       Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger "
                                            data-original-title="" title=""
                                            onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <a rel="tooltip" class="btn btn-sm btn-outline-success"
                                   href="{{ route('profile.edit') }}" data-original-title=""
                                   title="">
                                    Edit
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection