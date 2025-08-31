<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Conference Registration</title>
    <meta name="description" content="Sign up for our amazing conference" />
    <link rel="shortcut icon" href="./assets/logo/logo.png" type="image/x-icon" />

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Conference Registration" />
    <meta property="og:description" content="Sign up for our amazing conference" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @filamentStyles
    @livewireStyles
</head>

<body class="flex min-h-[100vh] flex-col bg-black text-white">
    <header class="max-w-lg:px-4 max-w-lg:mr-auto absolute top-0 z-20 flex h-[60px] w-full bg-opacity-0 px-[5%] lg:justify-around">
        <a class="h-[50px] w-[50px] p-[4px]" href="">
            <img src="./assets/logo/logo.png" alt="logo" class="object h-full w-full" />
        </a>
        <div class="collapsible-header animated-collapse max-lg:shadow-md" id="collapsed-header-items">
            <div class="flex h-full w-max gap-5 text-base max-lg:mt-[30px] max-lg:flex-col max-lg:place-items-end max-lg:gap-5 lg:mx-auto lg:place-items-center">
                <a class="header-links" href=""> About us </a>
                <a class="header-links" href="#pricing"> Pricing </a>
                <a class="header-links" href=""> Solutions </a>
                <a class="header-links" href=""> Features </a>
                <a class="header-links" href=""> Company </a>
            </div>
            <div class="mx-4 flex place-items-center gap-[20px] text-base max-md:w-full max-md:flex-col max-md:place-content-center">
                <a href="" aria-label="signup" class="rounded-full bg-white px-3 py-2 text-black transition-transform duration-[0.3s] hover:translate-x-2">
                    <span>Get started</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <button class="bi bi-list absolute right-3 top-3 z-50 text-3xl text-white lg:hidden" onclick="toggleHeader()" aria-label="menu" id="collapse-btn"></button>
    </header>

    <main>
        {{ $slot }}
    </main>

    <x-filament-actions::modals />
    @livewire('notifications')
    @livewireScripts
    @filamentScripts

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js"
        integrity="sha512-B1lby8cGcAUU3GR+Fd809/ZxgHbfwJMp0jLTVfHiArTuUt++VqSlJpaJvhNtRf3NERaxDNmmxkdx2o+aHd4bvw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/ScrollTrigger.min.js"
        integrity="sha512-AY2+JxnBETJ0wcXnLPCcZJIJx0eimyhz3OJ55k2Jx4RtYC+XdIi2VtJQ+tP3BaTst4otlGG1TtPJ9fKrAUnRdQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="./index.js"></script>
</body>

</html>

<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        {{ $slot }}

        @livewire('notifications')

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html> -->