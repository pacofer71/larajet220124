<x-app-layout>
    <x-propios.principal>
        <div class="p-4 rounded-xl w-1/2 mx-auto flex justify-around items-center">
            <div>
                <a href="{{route('categories.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gestionar Categorías</a>
            </div>
            <div>
                <a href="{{route('posts.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gestionar Posts</a>
            </div>
        </div>

        </div>
    </x-propios.principal>
</x-app-layout>
