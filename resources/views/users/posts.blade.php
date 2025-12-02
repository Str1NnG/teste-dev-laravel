@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>
        
        <img src="{{ $user->image }}" alt="" class="h-32 w-32 rounded-full border-4 border-indigo-50 shadow-lg object-cover z-10 bg-white">
        
        <div class="text-center md:text-left flex-grow z-10">
            <h1 class="text-3xl font-extrabold text-gray-900">{{ $user->firstName }} {{ $user->lastName }}</h1>
            <p class="text-indigo-600 font-medium mb-4">{{ $user->email }}</p>
            
            <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-gray-500">
                <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md">
                    📍 {{ $user->address['city'] ?? 'N/A' }}, {{ $user->address['state'] ?? '' }}
                </span>
                <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md">
                    🎂 {{ \Carbon\Carbon::parse($user->birthDate)->format('d/m/Y') }}
                </span>
                <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md">
                    💼 {{ $user->company['title'] ?? 'N/A' }}
                </span>
            </div>
        </div>
        
        <div class="text-center bg-indigo-50 p-4 rounded-lg min-w-[120px]">
            <span class="block text-3xl font-bold text-indigo-700">{{ $posts->total() }}</span>
            <span class="text-xs font-bold text-indigo-400 uppercase tracking-wide">Publicações</span>
        </div>
    </div>

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Publicações do Usuário</h2>
        <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Ver todos os posts &rarr;</a>
    </div>

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
                    <span class="text-xs text-gray-400 font-semibold">{{ $post->created_at->format('d/m/Y') }}</span>
                    
                    <div class="flex gap-3 text-xs text-gray-500 font-semibold select-none">
                        <button onclick="sendReaction({{ $post->id }}, 'like')" class="flex items-center gap-1 hover:text-green-600 transition active:scale-95" title="Curtir">
                            👍 <span id="like-count-{{ $post->id }}">{{ $post->likes }}</span>
                        </button>
                        
                        <button onclick="sendReaction({{ $post->id }}, 'dislike')" class="flex items-center gap-1 hover:text-red-600 transition active:scale-95" title="Descurtir">
                            👎 <span id="dislike-count-{{ $post->id }}">{{ $post->dislikes }}</span>
                        </button>
                        
                        <span class="flex items-center gap-1 cursor-default">
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
@endsection