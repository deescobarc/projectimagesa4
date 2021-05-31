<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar imagen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('images.store') }}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                        <div class="grid grid-cols-6 gap-4 px-4 py-5 bg-white sm:p-6">
                                            <div class="col-start-2 col-span-4">
                                                <label for="name" class="block text-sm font-medium text-gray-700">
                                                    Nombre
                                                </label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                      <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                        <i class="bi bi-info-circle"></i>
                                                      </span>
                                                    <input type="text" name="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Ingrese un nombre para la imagen">
                                                </div>
                                            </div>
                                            <div class="col-start-2 col-span-4">
                                                <label for="description" class="block text-sm font-medium text-gray-700">
                                                    Descripción
                                                </label>
                                                <div class="mt-1">
                                                    <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ingrese la descripción de la imagen"></textarea>
                                                </div>
                                            </div>
{{--                                            <div class="col-start-2 col-span-4">--}}
{{--                                                <label class="block text-sm font-medium text-gray-700">--}}
{{--                                                    Photo--}}
{{--                                                </label>--}}
{{--                                                <div class="mt-1 flex items-center">--}}
{{--                                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">--}}
{{--                                                      <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">--}}
{{--                                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />--}}
{{--                                                      </svg>--}}
{{--                                                    </span>--}}
{{--                                                    <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                                                        Change--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="col-start-2 col-span-4">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Imagen
                                                </label>
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600">
                                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                                <span>Cargar imagen</span>
                                                                <input id="file-upload" name="file-upload" type="file" class="sr-only" accept=".jpg, .jpeg" required>
                                                            </label>
                                                            <p class="pl-1">o arrastra y suelta</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">
                                                            JPG, máximo 10MB
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
