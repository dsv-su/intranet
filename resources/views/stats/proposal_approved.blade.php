@extends('layouts.app')
@section('content')
    @nocache('dsvheader')
    <!-- PP header -->
    @include('pp.partials.header')

    @include('pp.partials.breadcrumb')

    @include('pp.partials.flashmessage')

    @include('stats.partials.tabs')

    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-6xl px-4 py-8 mx-auto lg:py-16">
            <!-- Flex container to align button to the right -->
            <div class="flex justify-between items-center">
                <h3 class="text-2xl dark:text-white">Granted Proposals</h3>
                <a type="button"
                   href="{{route('pp-recalc')}}"
                   class="inline-flex items-center px-2 py-2 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.65rem]
                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                            disabled:opacity-25 transition ease-in-out duration-150">
                    ReCalc
                </a>
            </div>

            <!-- First row -->
            <div class="lg:flex lg:gap-8 mt-6">
                <div class="w-full lg:w-1/2">
                    <h5 class="text-xl dark:text-white">Granted Proposals</h5>
                    <x-chartjs-component :chart="$chart['researchsubject_approved']" />
                </div>
                {{--}}
                <div class="w-full lg:w-1/2">
                    <h5 class="text-xl dark:text-white">Granted total</h5>
                    <x-chartjs-component :chart="$chart['researchsubject_final']" />
                </div>
                {{--}}
            </div>

            <!-- Second row -->
            {{--}}
            <div class="lg:flex lg:gap-8 mt-6">
                <div class="w-full lg:w-1/2">
                    <h5 class="text-xl dark:text-white">Funding Agency</h5>
                    <x-chartjs-component :chart="$chart['agency']" />
                </div>
                <div class="w-full lg:w-1/2">
                    <h5 class="text-xl dark:text-white">PhD years</h5>
                    <x-chartjs-component :chart="$chart['researchsubject_phd']" />
                </div>
            </div>
            {{--}}
        </div>
    </section>



    @nocache('layouts.darktoggler')
@endsection
