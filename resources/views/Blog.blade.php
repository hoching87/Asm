@extends('layouts.frontend')

@section('content')

<div class="container px-6 mx-6 my-6 px-6 py-6">
        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

            @foreach ($blogs as $blog)

            <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md">
                <a href="{{ $blog->link}}"><div class="flex items-end justify-end w-full bg-cover">
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase">{{ $blog->blogTitle }}</h3>
                        <span class="mt-2 text-gray-500">{{ $blog->author }}</span>
                        <img src="{{ asset('uploads/images/'.$blog->pictures )}}" width="300" height="333" >
                    </div>
                </div></a>
            </div>
            @endforeach
        </div>
</div>

@endsection