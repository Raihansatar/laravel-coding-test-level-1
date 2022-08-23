@extends('layouts.main')

@section('toolbar')
@endsection


@section('content')
    <div class="container">
        @include('layouts.flash-message')

        <div class="card">
            <div class="card-header">
                Random Anime Quote
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label for="">Anime</label>
                        <input type="text" name="anime" value="{{ isset($data['anime']) ? $data['anime'] : null }}" readonly placeholder="Anime" class="form-control" id="anime">
                    </div>
                    <div class="col-6">
                        <label for="">Character</label>
                        <input type="text" name="character" value="{{ isset($data['character']) ? $data['character'] : null }}" readonly placeholder="Character" class="form-control" id="character">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="">Quote </label>
                        <textarea rows="5" type="text" name="quote" readonly placeholder="Quote" class="form-control" id="quote">{{ isset($data['quote']) ? $data['quote'] : null }}</textarea>
                    </div>
                </div>
                <div class="row d-flex justify-content-around">
                    <button class="btn btn-primary" onclick="fetchQuote()">Fetch via client side</button>
                    <form action="" method="get">
                        <button class="btn btn-success" value="fetch" name="action">Fetch via server side</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
<script>

    function fetchQuote(){

        let anime = document.getElementById("anime");
        let character = document.getElementById("character");
        let quote = document.getElementById("quote");

        anime.value = 'Loading...';
        character.value = 'Loading...';
        quote.value = 'Loading...';

        fetch(" {{ config('api.anime_quote_url') }}")
        .then(response => response.json())
        .then(quoteObject => {
            anime.value = quoteObject.anime
            character.value = quoteObject.character
            quote.value = quoteObject.quote
        })
    }

</script>
@endpush
