<x-propios.principal>
    <div class="flex w-full mb-1 items-center">
        <div class="flex-1 ">
            <x-input class="w-3/4" placeholder="Buscar..." type="search" wire:model.live="search" /><i class="ml-1 fas fa-search"></i>
        </div>
        <div>
            @livewire('crear-post')
        </div>
    </div>
    @if(count($posts))
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-1 py-3">
                    INFO
                </th>
                <th scope="col" class="px-6 py-3">
                    IMAGEN
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('titulo')">
                    TITULO <i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('estado')">
                    ESTADO <i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $item)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <button><i class="fas fa-info text-xl hover:text-2xl"></i></button>
                    </td>
                    <th scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-10 h-10 rounded-full" src="{{Storage::url($item->imagen)}}"
                            alt="Jese image">
                    </th>
                    <td class="px-6 py-4 font-bold">
                        {{$item->titulo}}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div @class([
                                "h-3.5 w-3.5 rounded-full me-2",
                                "bg-green-500"=>$item->estado=="PUBLICADO",
                                "bg-red-500"=>$item->estado=="BORRADOR",

                            ])></div> {{$item->estado}}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                       <button wire:click="pedirConfirmacion('{{$item->id}}')">
                        <i class="fas fa-trash text-xl hover:text-2xl"></i>
                       </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else 
    <p class="p-2 rounded-xl bg-gray-600 text-white">
        No se encontró ningún post o aun no creo ninguno, aproveche para crear uno nuevo.
    </p>
    @endif
    <div class="mt-1">
        {{$posts->links()}}
    </div>
</x-propios.principal>
