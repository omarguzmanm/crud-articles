<div class="p-2 lg:p-8 bg-white border-b border-gray-200">
    <div class="mt-4 text-2xl flex justify-between shadow-inner">
        <div> Articulos</div>
        <div class="mr-2">
            <x-button class="bg-sky-600	hover:bg-sky-800"  wire:click="confirmArticleAdd">
                Crear nuevo articulo
            </x-button>
        </div>
    </div>

    {{-- {{$query}} --}}
    <div class="mt-3">
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.500ms="q" type="search" name="" id="" placeholder="Buscar" class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-blue-400">
            </div>
            <div class="mr-2">
                <input type="checkbox" class="mr-2 leading-tight" name="" wire:model="active">¿Solo Activos?
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">Id</button>
                                @if($sortBy == 'id')
                                    @if($sortAsc)
                                        <span class="w-4 h-4 ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </span>
                                    @endif
                                    @if(!$sortAsc)
                                        <span class="w-4 h-4 ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                            </svg>
                                        </span>
                                    @endif  
                            @endif                                
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Descripcion</button>
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('price')">Precio</button>
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('quantity')">Cantidad</button>
                        </div>
                    </th>
                    @if (!$active)
                    <th class="px-4 py-2">
                        Status
                    </th>
                    @endif
                    <th class="px-4 py-2">
                            Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td class="rounded boder px-4 py-2">{{$article->id}}</td>
                        <td class="rounded boder px-4 py-2">{{$article->name}}</td>
                        <td class="rounded boder px-4 py-2">{{number_format($article->price,2)}}</td>
                        <td class="rounded boder px-4 py-2">{{$article->quantity}}</td>
                        @if (!$active)
                        <td class="rounded boder px-4 py-2">{{$article->status ? 'Activo' :'Inactivo'}}</td>
                        @endif
                        <td class="rounded boder px-4 py-2 ">
                            <x-button class="bg-green-500	hover:bg-green-800" wire:click="confirmArticleEdit({{$article->id}})" >
                                Editar articulo
                            </x-button> 
                            <x-danger-button wire:click="confirmArticleDeletion ({{$article->id}})" wire:loading.attr="disabled">
                                {{ __('Eliminar') }}
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{$articles->links()}}
    </div>

    <x-dialog-modal wire:model="confirmingArticleDeletion">
        <x-slot name="title">
            {{ __('Eliminar articulo') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Está seguro que desea eliminar el articulo?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingArticleDeletion' , false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteArticle ({{$confirmingArticleDeletion}})" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="confirmingArticleAdd">
        <x-slot name="title">
            {{ isset($this->article->id) ? 'Editar articulo' : 'Crear articulo'}}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Descripción') }}" />
                <x-input id="article.name" type="text" class="mt-1 block w-full" wire:model.defer="article.name"/>
                <x-input-error for="article.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-label for="price" value="{{ __('Precio') }}" />
                <x-input id="article.price" type="text" class="mt-1 block w-full" wire:model.defer="article.price"/>
                <x-input-error for="article.price" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-label for="quantity" value="{{ __('Cantidad') }}" />
                <x-input id="article.quantity" type="text" class="mt-1 block w-full" wire:model.defer="article.quantity"/>
                <x-input-error for="article.quantity" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <label class="flex items-center">
                    <input type="checkbox" wire:model.defer="article.status" name="" id="">
                    <span class="ml-2 text-sm text-gray-600">Activo</span>
                </label>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingArticleAdd' , false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="saveArticle ()" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

</div>