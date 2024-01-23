<x-app-layout>
    <x-propios.principal>
        <div class="flex flex-row-reverse mb-2">
            <a href="{{ route('categories.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i class="fas fa-add"></i>
                NUEVA</a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            DESCRIPCION
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->descripcion }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('categories.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <a href="{{ route('categories.edit', $item) }}" class="mr-2">
                                        <i class="fas fa-edit text-green-400 hover:text-2xl"></i>
                                    </a>
                                    <button type="submit">
                                        <i class="fas fa-trash text-red-400 hover:text-2xl"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2">
            {{ $categorias->links() }}
        </div>
    </x-propios.principal>
</x-app-layout>
