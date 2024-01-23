<x-app-layout>
    <x-propios.principal>
        <div
            class="p-2 border-2 border-gray-500 shadow-xl rounded-xl w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($posts as $item)
                <article style="background-image:url({{ Storage::url($item->imagen) }})" @class([
                    'h-72 bg-cover bg-center bg-no-repeat',
                    'md:col-span-2 lg:cols-span-2' => $loop->first,
                ])>
                    <a href="#">
                        <div
                            class="w-full h-full flex flex-col justify-around items-center p-2 bg-gray-200 bg-opacity-50">
                            <div class="text-xl font-bold text-black">
                                {{ $item->titulo }}
                            </div>
                            <div class="flex">
                              <p class="p-2 rounded-xl text-teal-200 bg-teal-700 italic">{{$item->user->email}}</p>
                           </div>
                            <div class="flex">
                               <p class="p-2 rounded-xl text-gray-200 bg-gray-700">{{$item->category->nombre}}</p>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $posts->links() }}
        </div>
    </x-propios.principal>
</x-app-layout>
