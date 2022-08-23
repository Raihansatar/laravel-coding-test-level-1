@extends('layouts.main')

@section('toolbar')
    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('event.index') }}" class="btn btn-secondary mr-2">Back</a>
        @auth()
            <a href="{{ route('event.edit', ['id' => $event->id]) }}" class="btn btn-warning">Edit</a>
        @endauth
    </div>
@endsection


@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="card">
            <div class="card-header">
                    Event Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="" class="font-weight-bold">Name</label>
                        <input type="text" name="name" class="form-control-plaintext" value="{{ $event->name }}" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="" class="font-weight-bold">Slug</label>
                        <input type="text" name="slug" class="form-control-plaintext" value="{{ $event->slug }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="" class="font-weight-bold">Start At</label>
                        <input type="datetime-local" name="start_at" value="{{ $event->start_at->format('Y-m-d H:i:s') }}" class="form-control-plaintext" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="" class="font-weight-bold">End At</label>
                        <input type="datetime-local" name="end_at" value="{{ $event->end_at->format('Y-m-d H:i:s') }}" class="form-control-plaintext" readonly>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

