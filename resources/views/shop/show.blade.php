@extends('layouts.app')

@section('content')

    <div class="grid sm:grid-cols-2 gap-2 pt-12 sm:pt-20 mx-auto w-4/5">
        <div class="mx-auto">
            <img 
                src="{{ asset($product->image_path) }}" 
                alt="{{ $product->name }}">
        </div>

        <div>
            <h1 class="text-4xl text-gray-600 font-bold pb-8">
                {{ $product->name }}
            </h1>

            <p class="font-bold text-l text-black pb-8">
               Price: <span class="text-red-500">$ {{ $product->price }}</span>
            </p>
            
            <p class="font-bold text-l text-black pb-8">
                Shipping: <span class="text-red-500">$ {{ $product->shipping_cost }}</span>
            </p>
            
            <p class="font-thin text-s text-black pb-8">
                {{ $product->details }}
            </p>            

            <p class="text-gray-800 text-thin text-l leading-6 pb-12">
                {{ $product->description }}
            </p>

            <a 
                href="{{ route('add.to.cart', $product->id) }}"
                class="px-10 py-6 text-l uppercase text-white font-bold bg-blue-600 rounded-full w-full" 
                role="button" 
                aria-pressed="true">
                Add To Cart
            </a>
        </div>
@endsection