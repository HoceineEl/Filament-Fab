@use('Filament\Support\Facades\FilamentAsset')
<div>
    <div x-data="floatingActionButton({
        defaultPosition: '{{ $position }}',
        rememberPosition: {{ $rememberPosition ? 'true' : 'false' }}
    })" @click.outside="open = false">
        <div class="floating-container" x-ref="container"
            :style="{ position: 'fixed', top: `${position.top}px`, left: `${position.left}px` }"
            @mousedown.prevent="startDragging">
            <div class="floating-menu" :class="{ 'active': open }">
                <!-- Main Button -->
                <button class="floating-button" @click="toggleMenu" :class="{ 'active': open }">
                    <x-filament::icon icon="heroicon-o-plus" class="icon" />
                </button>

                <!-- Menu Items -->
                <div x-show="open" class="menu-items" :class="{ 'active': open }">
                    @foreach ($actions as $action)
                        <div class="menu-item">
                            {{ $action }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <x-filament-actions::modals />
    </div>
</div>
