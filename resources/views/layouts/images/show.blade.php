<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Imagen en Hoja A4') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <div class="flex justify-center" id="main">
                    <canvas id="canvas"></canvas>
{{--                    <canvas id="canvas"></canvas>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="hidden">
        <img id="imageLoad" src="{{asset('storage/images/' . $image->route)}}" />
    </div>
</x-app-layout>
