@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    List of Events
                </div>
            </div>
            <div class="card-body">
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
                            <td>{{ $event->name }}</td>
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
@endsection

