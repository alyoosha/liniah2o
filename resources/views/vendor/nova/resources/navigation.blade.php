@if (count(\Laravel\Nova\Nova::availableResources(request())))
    <h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
            />
        </svg>
        <span class="sidebar-label">{{ __('Resources') }}</span>
    </h3>

    @foreach($navigation as $group => $resources)
        @if (count($groups) > 1)
            <h4 class="ml-8 mb-4 text-xs text-white-50% uppercase tracking-wide">{{ $group }}</h4>
        @endif

        <ul class="list-reset mb-8">
            @foreach($resources as $resource)
                @if($resource::uriKey() == 'homepages')
                    <li class="leading-tight mb-4 ml-8 text-sm">
                        <router-link :to="{
                                name: 'edit',
                                params: {
                                    resourceName: '{{ $resource::uriKey() }}',
                                    resourceId: '1'
                                }
                            }" class="text-white text-justify no-underline dim">
                            {{ $resource::label() }}
                        </router-link>
                    </li>
                    @continue
                @endif
                @if($resource::uriKey() == 'abouts')
                    <li class="leading-tight mb-4 ml-8 text-sm">
                        <router-link :to="{
                            name: 'edit',
                            params: {
                                resourceName: '{{ $resource::uriKey() }}',
                                resourceId: '1'
                            }
                        }" class="text-white text-justify no-underline dim">
                            {{ $resource::label() }}
                        </router-link>
                    </li>
                    @continue
                @endif
                @if($resource::uriKey() == 'payment-and-deliveries')
                    <li class="leading-tight mb-4 ml-8 text-sm">
                        <router-link :to="{
                                name: 'edit',
                                params: {
                                    resourceName: '{{ $resource::uriKey() }}',
                                    resourceId: '1'
                                }
                            }" class="text-white text-justify no-underline dim">
                            {{ $resource::label() }}
                        </router-link>
                    </li>
                    @continue
                @endif
                @if($resource::uriKey() == 'contacts')
                    <li class="leading-tight mb-4 ml-8 text-sm">
                        <router-link :to="{
                                name: 'edit',
                                params: {
                                    resourceName: '{{ $resource::uriKey() }}',
                                    resourceId: '1'
                                }
                            }" class="text-white text-justify no-underline dim">
                            {{ $resource::label() }}
                        </router-link>
                    </li>
                    @continue
                @endif
                @if($resource::uriKey() == 'warranty-periods')
                    <li class="leading-tight mb-4 ml-8 text-sm">
                        <router-link :to="{
                                name: 'detail',
                                params: {
                                    resourceName: '{{ $resource::uriKey() }}',
                                    resourceId: '1'
                                }
                            }" class="text-white text-justify no-underline dim">
                            {{ $resource::label() }}
                        </router-link>
                    </li>
                    @continue
                @endif
                @if($resource::uriKey() == 'exploitation-rules')
                    <li class="leading-tight mb-4 ml-8 text-sm">
                        <router-link :to="{
                                name: 'detail',
                                params: {
                                    resourceName: '{{ $resource::uriKey() }}',
                                    resourceId: '1'
                                }
                            }" class="text-white text-justify no-underline dim">
                            {{ $resource::label() }}
                        </router-link>
                    </li>
                    @continue
                @endif
                <li class="leading-tight mb-4 ml-8 text-sm">
                    <router-link :to="{
                        name: 'index',
                        params: {
                            resourceName: '{{ $resource::uriKey() }}'
                        }
                    }" class="text-white text-justify no-underline dim">
                        {{ $resource::label() }}
                    </router-link>
                </li>
            @endforeach
        </ul>
    @endforeach
@endif
