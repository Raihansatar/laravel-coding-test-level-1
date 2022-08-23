@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="card">
            <div class="card-header">
                Edit Event
            </div>
            <form action="{{ route('event.update', ['id' => $event->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">Start At<span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_at" value="{{ $event->start_at->format('Y-m-d H:i:s') }}" class="form-control" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">End At<span class="text-danger">*</span></label>
                            <input type="datetime-local" name="end_at" value="{{ $event->end_at->format('Y-m-d H:i:s') }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">Cancel</a>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
            </form>

    </div>
@endsection

