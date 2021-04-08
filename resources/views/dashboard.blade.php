<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @include('components.user-balance')

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{route('recharge-balance')}}">
                    @csrf

                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">

                                <div class="col-span-12">
                                    <label for="recharge-balance"
                                           class="block text-sm font-medium text-gray-700">Recharge balance</label>
                                    <input type="text" name="recharge-balance" id="recharge-balance"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="px-4 py-5 bg-red-400 sm:p-6">
                                <ul class="pt-4">
                                    @foreach ($errors->all() as $error)
                                        <li class="pb-4 font-bold text-black">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enter
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
