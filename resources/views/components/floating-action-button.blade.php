@use('Filament\Support\Facades\FilamentAsset')

<div>
    <div x-data="{
        open: false,
        dragging: false,
        position: { top: 100, left: 100 },
        offset: { x: 0, y: 0 },
        theme: {
            buttonSize: '{{ $theme['button_size'] }}',
            menuItemSize: '{{ $theme['menu_item_size'] }}',
            menuWidth: '{{ $theme['menu_width'] }}',
            menuSpacing: '{{ $theme['menu_spacing'] }}',
            animationSpeed: '{{ $theme['animation_speed'] }}',
            animationEasing: '{{ $theme['animation_easing'] }}',
        },
    
        init() {
            // Set default config
            const defaultPosition = '{{ $position }}';
            const rememberPosition = {{ $rememberPosition ? 'true' : 'false' }};
    
            const defaultPos = this.getDefaultPositionCoordinates(defaultPosition);
    
            // Load saved position from localStorage if enabled
            if (rememberPosition) {
                const savedPosition = JSON.parse(localStorage.getItem('FAB-position') || 'null');
                if (savedPosition) {
                    this.position = savedPosition;
                } else {
                    this.position = defaultPos;
                }
            } else {
                this.position = defaultPos;
            }
    
            // Add global mouse event listeners
            window.addEventListener('mousemove', (e) => this.onDrag(e));
            window.addEventListener('mouseup', () => this.stopDragging());
    
            // Set animation order for menu items
            this.$nextTick(() => {
                this.$el.querySelectorAll('.menu-item').forEach((item, index) => {
                    item.style.setProperty('--animation-order', index);
                });
            });
    
            // Apply theme CSS variables
            document.documentElement.style.setProperty('--fab-button-size', this.theme.buttonSize);
            document.documentElement.style.setProperty('--fab-menu-item-size', this.theme.menuItemSize);
            document.documentElement.style.setProperty('--fab-menu-width', this.theme.menuWidth);
            document.documentElement.style.setProperty('--fab-menu-spacing', this.theme.menuSpacing);
            document.documentElement.style.setProperty('--fab-animation-speed', this.theme.animationSpeed);
            document.documentElement.style.setProperty('--fab-animation-easing', this.theme.animationEasing);
        },
    
        getDefaultPositionCoordinates(position) {
            const windowWidth = window.innerWidth;
            const windowHeight = window.innerHeight;
    
            switch (position) {
                case 'bottom-right':
                    return { top: windowHeight - 100, left: windowWidth - 100 };
                case 'bottom-left':
                    return { top: windowHeight - 100, left: 100 };
                case 'top-right':
                    return { top: 100, left: windowWidth - 100 };
                case 'top-left':
                    return { top: 100, left: 100 };
                default:
                    return { top: windowHeight - 100, left: windowWidth - 100 };
            }
        },
    
        toggleMenu() {
            this.open = !this.open;
    
            // Reset animation order when menu opens
            if (this.open) {
                this.$nextTick(() => {
                    this.$el.querySelectorAll('.menu-item').forEach((item, index) => {
                        item.style.setProperty('--animation-order', index);
                    });
                });
            }
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
            const rememberPosition = {{ $rememberPosition ? 'true' : 'false' }};
            if (rememberPosition) {
                localStorage.setItem('FAB-position', JSON.stringify(this.position));
            }
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
            if (!container) return;
    
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
    }" @click.outside="open = false">
        <div class="floating-container" x-ref="container"
            :style="{ position: 'fixed', top: `${position.top}px`, left: `${position.left}px` }"
            @mousedown.prevent="startDragging">
            <div class="floating-menu" :class="{ 'active': open }"
                :style="{ width: open ? theme.menuWidth : theme.buttonSize }">
                <!-- Main Button -->
                <button class="floating-button group" @click="toggleMenu" :class="{ 'active': open }"
                    :style="{ width: theme.buttonSize, height: theme.buttonSize }">
                    <x-filament::icon icon="heroicon-o-plus" class="icon" />
                    <span class="fab-tooltip">{{ __('filament-fab::actions.quick_actions') }}</span>
                </button>

                <!-- Menu Items -->
                <div x-show="open" class="menu-items" :class="{ 'active': open }"
                    :style="{ height: theme.buttonSize, gap: theme.menuSpacing }">
                    @foreach ($actions as $action)
                        <div class="menu-item" :style="{ width: theme.menuItemSize, height: theme.menuItemSize }">
                            {{ $action }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <x-filament-actions::modals />
    </div>
</div>
