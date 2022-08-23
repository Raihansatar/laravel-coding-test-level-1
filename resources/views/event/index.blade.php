@extends('layouts.main')

@section('toolbar')
    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('event.create') }}" class="btn btn-success">Add event</a>
    </div>
@endsection

@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="card card-body mb-4">
            <form action="{{ route('event.index') }}" method="GET">
                <div class="row">
                    <div class="form-group col-4">
                        <label for="">Name</label>
                        <input type="text" value="{{ request()->name }}" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group col-4">
                        <label for="">Date</label>
                        <input type="datetime-local" value="{{ request()->date }}" name="date" class="form-control">
                    </div>
                    <div class="form-group col-4">
                        <label for="">Per page</label>
                        <select name="per_page" class="form-control" id="">
                            <option value="10" {{ request()->per_page == 10? 'selected': null }}>10</option>
                            <option value="15" {{ request()->per_page == 15? 'selected': null }}>15</option>
                            <option value="50" {{ request()->per_page == 50? 'selected': null }}>50</option>
                            <option value="100" {{ request()->per_page == 100? 'selected': null }}>100</option>
                        </select>
                    </div>
                    <div class="form-group col-2 my-auto">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                List of Events
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Start At</th>
                                <th>End At</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = ($events->currentPage() * $events->perPage()) - $events->perPage() + 1;
                            @endphp
                            @foreach ($events as $event)
                            <tr>
                                <td>{{ $index++ }} </td>
                                <td>
                                    <a href="{{ route('event.show', ['id' => $event->id]) }}">{{ $event->name }}</a>
                                </td>
                                <td>{{ $event->slug }}</td>
                                <td>{{ $event->start_at->format('d/m/Y g:ia') }}</td>
                                <td>{{ $event->end_at->format('d/m/Y g:ia') }}</td>
                                <td>{{ $event->created_at->format('d/m/Y g:ia') }}</td>
                                <td>{{ $event->updated_at->format('d/m/Y g:ia') }}</td>
                                <td class="">
                                    <a href="{{ route('event.edit', ['id' => $event->id]) }}" class="btn btn-sm btn-primary m-1">Edit</a>
                                    <form action="{{ route('event.destroy', ['id' => $event->id]) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger m-1">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{ $events->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

