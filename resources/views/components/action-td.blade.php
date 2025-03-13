<button
    @click="open['{{ $id }}'] = !open['{{ $id }}']; up = $event.target.getBoundingClientRect().top > window.innerHeight / 2"
    id="button-menu-{{ $id }}"
    class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-green-600 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-white relative"
    type="button">
    <svg class="w-8 h-8 hover:scale-150" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
    </svg>
    <div :class="{ 'top-full': !up, 'bottom-full': up }" x-show="open['{{ $id }}']" x-cloak
        @click.away="open['{{ $id }}'] = false" id="row-options-{{ $id }}"
        class="absolute top-full right-0 z-50 w-44 bg-white rounded-xl divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 text-gray-700 dark:text-gray-200">
        <ul class="py-1 text-base">
            @foreach ($routes as $route)
                @if ($route['name'] === 'Show')
                    <li>
                        <a href="{{ Route::has($route['route']) ? route($route['route'], $id) : '#' }}"
                            class="flex items-center py-2 px-4 rounded-lg hover:bg-green-700 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white"
                            @if (isset($route['target']) && $route['target'] === '_blank') target="_blank" @endif>
                            <svg class="w-7 h-7 pr-1 hover:scale-150" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4 6-9 6s-9-4.8-9-6c0-1.2 4-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            {{ __($route['name']) }}
                        </a>
                    </li>
                @elseif ($route['name'] === 'Edit')
                    <li>
                        <a href="{{ Route::has($route['route']) ? route($route['route'], $id) : '#' }}"
                            class="flex items-center py-2 px-4 rounded-lg hover:bg-green-700 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white"
                            @if (isset($route['target']) && $route['target'] === '_blank') target="_blank" @endif>
                            <svg class="w-7 h-7 pr-1 hover:scale-150" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m14.3 4.8 2.9 2.9M7 7H4a1 1 0 0 0-1 1v10c0 .6.4 1 1 1h11c.6 0 1-.4 1-1v-4.5m2.4-10a2 2 0 0 1 0 3l-6.8 6.8L8 14l.7-3.6 6.9-6.8a2 2 0 0 1 2.8 0Z" />
                            </svg>
                            {{ __($route['name']) }}
                        </a>
                    </li>
                @elseif ($route['name'] != 'Show' && $route['name'] != 'Edit' && $route['name'] != 'Destroy')
                    <li>
                        <a href="{{ Route::has($route['route']) ? route($route['route'], $id) : '#' }}"
                            class="flex items-center py-2 px-4 rounded-lg hover:bg-green-700 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white"
                            @if (isset($route['target']) && $route['target'] === '_blank') target="_blank" @endif>
                            <svg class="w-7 h-7 pr-1 hover:scale-150" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m16.2 19 4.8-7-4.8-7H3l4.8 7L3 19h13.2Z" />
                            </svg>
                            {{ __($route['name']) }}
                        </a>
                    </li>
                @elseif ($route['name'] === 'Destroy')
                    <li>
                        <div class="flex items-center py-2 px-4 rounded-lg hover:bg-red-700 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white"
                            onclick="confirmDelete('form-destroy-{{ $id }}');">
                            <svg class="w-7 h-7 pr-1 hover:scale-150" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                            </svg>
                            <form action="{{ Route::has($route['route']) ? route($route['route'], $id) : '#' }}"
                                method="POST" id="form-destroy-{{ $id }}">
                                @csrf @method($route['method'])
                            </form>
                            {{ __($route['name']) }}
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</button>
