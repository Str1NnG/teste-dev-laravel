@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Blog da Comunidade</h1>
            <p class="mt-2 text-lg text-gray-600">Explore histórias, novidades e discussões.</p>
        </div>

        <form method="GET" action="{{ route('home') }}" class="w-full md:w-auto flex-grow max-w-md">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Buscar por título..." 
                       class="block w-full pl-10 pr-20 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm transition shadow-sm"
                >
                <div class="absolute inset-y-0 right-0 flex items-center">
                    @if(request('search') || request('tag'))
                        <a href="{{ route('home') }}" class="mr-2 text-xs font-bold text-red-500 hover:text-red-700 uppercase tracking-wide">
                            Limpar
                        </a>
                    @else
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-1.5 px-4 rounded-md mr-1.5 transition">
                            Buscar
                        </button>
                    @endif
                </div>
            </div>
            
            @if(request('tag'))
                <div class="mt-2 text-sm text-indigo-600 font-medium">
                    Filtrando pela tag: <span class="font-bold">#{{ request('tag') }}</span>
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-red-500 ml-2 text-xs" title="Remover filtro">✕</a>
                </div>
            @endif
        </form>
    </div>

    @if($posts->count() == 0)
        <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
            <p class="text-xl text-gray-500 font-medium">Nenhum post encontrado para sua busca.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Limpar filtros</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden border border-gray-100">
                    <div class="p-6 flex-grow">
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('home', ['tag' => $tag]) }}" class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide hover:bg-indigo-100 hover:text-indigo-800 transition">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>

                        <a href="{{ route('posts.show', $post->id) }}" class="block group">
                            <h2 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h2>
                        </a>

                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                            {{ $post->body }}
                        </p>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full bg-indigo-200 flex items-center justify-center overflow-hidden">
                                @if($post->user && $post->user->image)
                                    <img src="{{ $post->user->image }}" alt="" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-indigo-700">{{ substr($post->user->firstName ?? 'U', 0, 1) }}</span>
                                @endif
                            </div>
                            <span class="text-xs font-medium text-gray-700 truncate max-w-[80px]">
                                {{ $post->user->firstName ?? 'Anônimo' }}
                            </span>
                        </div>

                        <div class="flex gap-3 text-xs text-gray-500 font-semibold select-none">
                            <button onclick="sendReaction({{ $post->id }}, 'like')" class="flex items-center gap-1 hover:text-green-600 transition active:scale-95" title="Curtir">
                                👍 <span id="like-count-{{ $post->id }}">{{ $post->likes }}</span>
                            </button>
                            
                            <button onclick="sendReaction({{ $post->id }}, 'dislike')" class="flex items-center gap-1 hover:text-red-600 transition active:scale-95" title="Descurtir">
                                👎 <span id="dislike-count-{{ $post->id }}">{{ $post->dislikes }}</span>
                            </button>
                            
                            <span class="flex items-center gap-1 cursor-default" title="Visualizações">
                                👁️ {{ $post->views }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @endif
@endsection