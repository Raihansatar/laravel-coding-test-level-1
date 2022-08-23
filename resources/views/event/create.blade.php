@extends('layouts.main')

@section('toolbar')
    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>
@endsection

@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="card">
            <div class="card-header">
                Create Event
            </div>
            <form action="{{ route('event.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">Slug</label>
                            <input type="text" name="slug" class="form-control" value="">
                            <span class="text-muted small">If empty, slug will be auto generated</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">Start At<span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_at" value="" class="form-control" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="" class="font-weight-bold">End At<span class="text-danger">*</span></label>
                            <input type="datetime-local" name="end_at" value="" class="form-control" required>
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

