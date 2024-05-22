@extends('layouts.main')

@section('header-title', 'Movies On Show')

@section('main')
<main>

    <h1 class="mt-6 pt-5 pb-10 font-semibold text-5xl text-gray-800 dark:text-gray-200 leading-tight">Movies On Show</h1>


    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="relative">
            <img src="caminho/para/a/capa/do/filme.jpg" alt="Capa do Filme" class="w-full">
            <div class="absolute top-0 left-0 p-4">
                <span class="bg-gray-900 text-white text-xs font-semibold uppercase px-2 py-1 rounded-full">Novo</span>
            </div>
        </div>
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800">Título do Filme</h2>
            <p class="text-gray-600 mt-2">Descrição do Filme</p>
            <div class="flex items-center mt-4">
                <svg class="w-4 h-4 fill-current text-gray-600" viewBox="0 0 24 24">
                    <path
                        d="M12 4c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 14c-3.313 0-6-2.687-6-6s2.687-6 6-6 6 2.687 6 6-2.687 6-6 6zm3-8H9a1 1 0 010-2h6a1 1 0 010 2z" />
                </svg>
                <span class="text-gray-700 ml-2">Ano de Lançamento: 2024</span>
            </div>
            <div class="flex items-center mt-2">
            </div>
        </div>
    </div>


    <!-- Caixa -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-18">
        <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-2xl text-gray-900 dark:text-gray-50">
            <h3 class="pb-3 font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Movies On Show
            </h3>
            <p class="py-3 font-medium text-gray-700 dark:text-gray-300">
                CINEMA - Página Inicial
            </p>
        </div>
    </div>
</main>
@endsection
