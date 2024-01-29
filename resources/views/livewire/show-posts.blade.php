<x-propios.principal>
    <div class="flex w-full mb-1 items-center">
        <div class="flex-1 ">
            <x-input class="w-3/4" placeholder="Buscar..." type="search" wire:model.live="search" /><i
                class="ml-1 fas fa-search"></i>
        </div>
        <div>
            @livewire('crear-post')
        </div>
    </div>
    @if (count($posts))
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
                            <img class="w-10 h-10 rounded-full" src="{{ Storage::url($item->imagen) }}"
                                alt="Jese image">
                        </th>
                        <td class="px-6 py-4 font-bold">
                            {{ $item->titulo }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div @class([
                                    'h-3.5 w-3.5 rounded-full me-2',
                                    'bg-green-500' => $item->estado == 'PUBLICADO',
                                    'bg-red-500' => $item->estado == 'BORRADOR',
                                ])></div> {{ $item->estado }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="edit({{ $item->id }})" class="mr-1">
                                <i class="fas fa-edit text-xl hover:text-2xl"></i>
                            </button>
                            <button wire:click="pedirConfirmacion('{{ $item->id }}')">
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
        {{ $posts->links() }}
    </div>
    <!-- Modal para actualizar un Post ---------------------------------------------->
    @isset($form->post)
        <x-dialog-modal wire:model="abrirModalUpdate">
            <x-slot name="title">
                EDITAR POST
            </x-slot>
            <x-slot name="content">
                <!-- Pinto el Formulario -->
                <x-label for="titulo">Título del Post</x-label>
                <x-input id="titulo" placeholder="Título..." class="w-full mb-2" wire:model="form.titulo" />
                <x-input-error for="form.titulo" />

                <x-label for="contenido">Contenido del Post</x-label>
                <textarea rows='4' class="w-full rounded mb-2" placeholder="Contenido..." wire:model="form.contenido"></textarea>
                <x-input-error for="form.contenido" />

                <x-label for="category_id">Categoria del Post</x-label>
                <select class="w-full rounded mb-2" id="category_id" wire:model="form.category_id">
                    <option>Selecciona una categoría</option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="form.category_id" />

                <x-label for="estado">Publicar Post</x-label>
                <div class="flex items-center mb-2">
                    <input @checked($form->estado == 'PUBLICADO') id="estado" type="checkbox" value="PUBLICADO"
                        wire:model="form.estado"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="estado" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Publicar</label>
                </div>
                <x-input-error for="form.estado" />

                <x-label for="imagen2">Imagen del Post</x-label>
                <div class="w-full h-72 rounded relative bg-gray-200">
                    @if ($form->imagen)
                        <img src="{{ $form->imagen->temporaryUrl() }}"
                            class="bg-cover bg-center bg-no-repeat w-full h-72" />
                    @else
                        <img src="{{ Storage::url($form->post->imagen) }}"
                            class="bg-cover bg-center bg-no-repeat w-full h-72" />
                    @endif
                    <input type="file" accept="image/*" id="imagen2" hidden wire:model="form.imagen" />
                    <label for="imagen2"
                        class="absolute bottom-2 right-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i>Upload</label>
                </div>
                <x-input-error for="form.imagen" />




            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse">
                    <button wire:click="update" wire:loading.attr='disabled'
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit"></i> EDITAR
                    </button>

                    <button wire:click="limpiarCerrarUpdate"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR
                    </button>
                </div>
            </x-slot>

        </x-dialog-modal>
    @endisset
    <!-- Fin Modal EDITAR------------------------------------------------------------------>
    <!-- MODAL PARA SHOW ------------------------------------------------------------------>
    <x-dialog-modal wire:model="abrirModalUpdate">
        <x-slot name="title">
            INFORMACION DEL POST
        </x-slot>
        <x-slot name="content">

        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row-reverse">
                <button wire:click=""
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
    <!-- FIN MODAL ------------------------------------------------------------------------->

</x-propios.principal>
