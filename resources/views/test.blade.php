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
    <form action="{{ route('pokemons.filter') }}" method="GET" class="flex flex-col mb-44">
        <div class="flex flex-wrap flex-row">
            <div class="lg:w-1/6 md:w-1/3 sm:w-1/2 flex flex-col mx-16 mb-20">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="gender">Gender</label>
                @error('gender') {{ $message }} @enderror
                <select class="mt-2" name="gender" id="gender">
                    @foreach($genders as $gender)
                        <option @if(old('gender') == $gender->value) selected @endif
                        value="{{ $gender->value }}"
                        >{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-1/6 md:w-1/3 sm:w-1/2 flex flex-col mx-16 mb-20">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="growth_rate">Growth rate</label>
                @error('growth_rate') {{ $message }} @enderror
                <select class="mt-2" name="growth_rate" id="growth_rate">
                    @foreach($growth_rates as $growth_rate)
                        <option @if(old('growth_rate') == $growth_rate->value) selected @endif
                        value="{{ $growth_rate->value }}"
                        >{{ $growth_rate->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-1/6 md:w-1/3 sm:w-1/2 flex flex-col mx-16 mb-20">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="nature">Nature</label>
                @error('nature') {{ $message }} @enderror
                <select class="mt-2" name="nature" id="nature">
                    @foreach($natures as $nature)
                        <option @if(old('nature') == $nature->value) selected @endif
                        value="{{ $nature->value }}"
                        >{{ $nature->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:w-1/6 md:w-1/3 sm:w-1/2 flex flex-col mx-16 mb-20">
                <label class="block text-sm font-medium leading-6 text-gray-900" for="color">Color</label>
                @error('color') {{ $message }} @enderror
                <select class="mt-2" name="color" id="color">
                    @foreach($colors as $color)
                        <option @if(old('color') == $color->value) selected @endif
                        value="{{ $color->value }}"
                        >{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit">Submit</button>
    </form>

    @if(session('pokemons'))
        <div class="container mx-auto flex flex-row flex-wrap">
            @foreach(session('pokemons') as $pokemon)
                <div
                    class="max-w-48 lg:w-1/6 md:w-1/4 rounded-lg border border-solid drop-shadow-lg mx-6 my-4 p-2 grow">
                    <img class="mx-auto min-h-24"
                         src="{{ $pokemon->getFirstMediaUrl('sprite') }}" alt="">
                    <h2 class="text-center uppercase">{{ $pokemon->name }}</h2>
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
