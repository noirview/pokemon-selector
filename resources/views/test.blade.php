<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    @vite('resources/css/app.css')
</head>
<body>
<div class="container mx-auto">
    <form action="{{ route('pokemons.filter') }}" method="GET" class="flex">
        <label for="gender">Gender</label>
        @error('gender') {{ $message }} @enderror
        <select name="gender" id="gender">
            @foreach($genders as $gender)
                <option @if(old('gender') == $gender->value) selected @endif value="{{ $gender->value }}">{{ $gender->name }}</option>
            @endforeach
        </select>
        <label for="growth_rate">Growth rate</label>
        @error('growth_rate') {{ $message }} @enderror
        <select name="growth_rate" id="growth_rate">
            @foreach($growth_rates as $growth_rate)
                <option @if(old('growth_rate') == $growth_rate->value) selected @endif value="{{ $growth_rate->value }}">{{ $growth_rate->name }}</option>
            @endforeach
        </select>
        <label for="nature">Nature</label>
        @error('nature') {{ $message }} @enderror
        <select name="nature" id="nature">
            @foreach($natures as $nature)
                <option @if(old('nature') == $nature->value) selected @endif value="{{ $nature->value }}">{{ $nature->name }}</option>
            @endforeach
        </select>
        <label for="color">Color</label>
        @error('color') {{ $message }} @enderror
        <select name="color" id="color">
            @foreach($colors as $color)
                <option @if(old('color') == $color->value) selected @endif value="{{ $color->value }}">{{ $color->name }}</option>
            @endforeach
        </select>

        <button type="submit">Submit</button>
    </form>

    @if(session('pokemons'))
        <div class="container mx-auto">
            @foreach(session('pokemons') as $pokemon)
                <div>
                    <h2>{{ $pokemon->name }}</h2>
                    <ul>
                        <li>Gender: {{ $pokemon->genders->pluck('gender') }}</li>
                        <li>Growth Rate: {{ $pokemon->growth_rate }}</li>
                        <li>Nature: {{ $pokemon->natures->pluck('nature') }}</li>
                        <li>Color: {{ $pokemon->color }}</li>
                        <li>Base experience: {{ $pokemon->base_experience }}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
