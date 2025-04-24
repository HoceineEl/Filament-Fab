@use('Filament\Support\Facades\FilamentAsset')
<div>
    <div x-data="floatingActionButton" x-init="initPosition" @click.outside="open = false">
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
@script
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('floatingActionButton', () => ({
                open: false,
                dragging: false,
                position: {
                    top: 100,
                    left: 100
                },
                offset: {
                    x: 0,
                    y: 0
                },

                initPosition() {
                    // Load saved position from localStorage
                    const savedPosition = JSON.parse(localStorage.getItem('FAB-position'));
                    if (savedPosition) {
                        this.position = savedPosition;
                    }

                    // Add global mouse event listeners
                    window.addEventListener('mousemove', (e) => this.onDrag(e));
                    window.addEventListener('mouseup', () => this.stopDragging());
                },

                toggleMenu() {
                    this.open = !this.open;
                },

                startDragging(e) {
                    if (e.target.closest('.menu-items')) return;

                    this.dragging = true;
                    this.offset = {
                        x: e.clientX - this.position.left,
                        y: e.clientY - this.position.top
                    };
                },

                stopDragging() {
                    if (!this.dragging) return;

                    this.dragging = false;
                    // Save position to localStorage
                    localStorage.setItem('FAB-position', JSON.stringify(this.position));
                },

                onDrag(e) {
                    if (!this.dragging) return;

                    // Calculate new position
                    this.position = {
                        top: e.clientY - this.offset.y,
                        left: e.clientX - this.offset.x
                    };

                    // Keep button within viewport bounds
                    const container = this.$refs.container;
                    const rect = container.getBoundingClientRect();

                    if (this.position.left < 0) this.position.left = 0;
                    if (this.position.top < 0) this.position.top = 0;
                    if (this.position.left + rect.width > window.innerWidth) {
                        this.position.left = window.innerWidth - rect.width;
                    }
                    if (this.position.top + rect.height > window.innerHeight) {
                        this.position.top = window.innerHeight - rect.height;
                    }
                }
            }));
        });
    </script>
@endscript
