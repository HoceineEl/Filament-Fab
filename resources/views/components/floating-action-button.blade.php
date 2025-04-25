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
            colors: {
                buttonBg: '{{ $theme['colors']['button_bg'] }}',
                buttonBgHover: '{{ $theme['colors']['button_bg_hover'] }}',
                buttonBgActive: '{{ $theme['colors']['button_bg_active'] }}',
                buttonText: '{{ $theme['colors']['button_text'] }}',
                menuBg: '{{ $theme['colors']['menu_bg'] }}',
                menuBgDark: '{{ $theme['colors']['menu_bg_dark'] }}',
                menuText: '{{ $theme['colors']['menu_text'] }}',
                menuTextDark: '{{ $theme['colors']['menu_text_dark'] }}',
                menuHover: '{{ $theme['colors']['menu_hover'] }}',
                menuHoverDark: '{{ $theme['colors']['menu_hover_dark'] }}',
                menuItemAccent: '{{ $theme['colors']['menu_item_accent'] }}',
                menuItemAccentDark: '{{ $theme['colors']['menu_item_accent_dark'] }}',
                tooltipBg: '{{ $theme['colors']['tooltip_bg'] }}',
                tooltipBgDark: '{{ $theme['colors']['tooltip_bg_dark'] }}',
                tooltipText: '{{ $theme['colors']['tooltip_text'] }}',
            }
        },
        menuDisplay: '{{ $menuDisplay }}',
    
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
            this.applyThemeColors();
    
            // Initialize the radial menu if selected
            if (this.menuDisplay === 'radial') {
                this.initRadialMenu();
            }
        },
    
        initRadialMenu() {
            this.$nextTick(() => {
                const items = this.$el.querySelectorAll('.menu-item');
                const itemCount = items.length;
    
                // Calculate radius based on button size and number of items
                const buttonSize = parseInt(this.theme.buttonSize);
                const radius = Math.max(buttonSize * 1.2, Math.min(120, itemCount * 25));
    
                // For radial menu, distribute items in a circle pattern
                items.forEach((item, index) => {
                    // For 1-2 items, just position them above
                    if (itemCount <= 2) {
                        const angle = Math.PI / 2; // 90 degrees (top)
                        const offsetAngle = index === 0 ? -0.3 : 0.3; // Slight offset for 2 items
                        const finalAngle = angle + (itemCount === 2 ? offsetAngle : 0);
                        const x = Math.cos(finalAngle) * radius;
                        const y = Math.sin(finalAngle) * radius;
    
                        // Position from center
                        item.style.transform = `translate(calc(-50% + ${x}px), calc(-50% - ${y}px))`;
                    } else {
                        // For 3+ items, create a 3/4 circle arc starting from top-right, moving clockwise
                        const arcAngle = Math.PI * 1.5; // 270 degrees arc (3/4 of a circle)
                        const startAngle = Math.PI / 4; // Start at 45 degrees (top-right)
                        const segmentAngle = arcAngle / (itemCount - 1 || 1);
                        const angle = startAngle + (index * segmentAngle);
    
                        // Calculate position
                        const x = Math.cos(angle) * radius;
                        const y = Math.sin(angle) * radius;
    
                        // Position from center with springy animation effect
                        item.style.transform = `translate(calc(-50% + ${x}px), calc(-50% - ${y}px))`;
    
                        // Set animation delay for staggered appearance
                        item.style.animationDelay = `${index * 0.05 + 0.1}s`;
                    }
                });
            });
        },
    
        applyThemeColors() {
            // Set layout variables
            document.documentElement.style.setProperty('--fab-button-size', this.theme.buttonSize);
            document.documentElement.style.setProperty('--fab-menu-item-size', this.theme.menuItemSize);
            document.documentElement.style.setProperty('--fab-menu-width', this.theme.menuWidth);
            document.documentElement.style.setProperty('--fab-menu-spacing', this.theme.menuSpacing);
            document.documentElement.style.setProperty('--fab-animation-speed', this.theme.animationSpeed);
            document.documentElement.style.setProperty('--fab-animation-easing', this.theme.animationEasing);
    
            // Set color variables
            document.documentElement.style.setProperty('--fab-button-bg', this.theme.colors.buttonBg);
            document.documentElement.style.setProperty('--fab-button-bg-hover', this.theme.colors.buttonBgHover);
            document.documentElement.style.setProperty('--fab-button-bg-active', this.theme.colors.buttonBgActive);
            document.documentElement.style.setProperty('--fab-button-text', this.theme.colors.buttonText);
            document.documentElement.style.setProperty('--fab-menu-bg', this.theme.colors.menuBg);
            document.documentElement.style.setProperty('--fab-menu-text', this.theme.colors.menuText);
            document.documentElement.style.setProperty('--fab-menu-hover', this.theme.colors.menuHover);
            document.documentElement.style.setProperty('--fab-menu-item-accent', this.theme.colors.menuItemAccent);
            document.documentElement.style.setProperty('--fab-tooltip-bg', this.theme.colors.tooltipBg);
            document.documentElement.style.setProperty('--fab-tooltip-text', this.theme.colors.tooltipText);
    
            // Update dark mode variables if a dark class is present
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.style.setProperty('--fab-menu-bg', this.theme.colors.menuBgDark);
                document.documentElement.style.setProperty('--fab-menu-text', this.theme.colors.menuTextDark);
                document.documentElement.style.setProperty('--fab-menu-hover', this.theme.colors.menuHoverDark);
                document.documentElement.style.setProperty('--fab-menu-item-accent', this.theme.colors.menuItemAccentDark);
                document.documentElement.style.setProperty('--fab-tooltip-bg', this.theme.colors.tooltipBgDark);
            }
    
            // Listen for dark mode changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        const isDark = document.documentElement.classList.contains('dark');
                        if (isDark) {
                            document.documentElement.style.setProperty('--fab-menu-bg', this.theme.colors.menuBgDark);
                            document.documentElement.style.setProperty('--fab-menu-text', this.theme.colors.menuTextDark);
                            document.documentElement.style.setProperty('--fab-menu-hover', this.theme.colors.menuHoverDark);
                            document.documentElement.style.setProperty('--fab-menu-item-accent', this.theme.colors.menuItemAccentDark);
                            document.documentElement.style.setProperty('--fab-tooltip-bg', this.theme.colors.tooltipBgDark);
                        } else {
                            document.documentElement.style.setProperty('--fab-menu-bg', this.theme.colors.menuBg);
                            document.documentElement.style.setProperty('--fab-menu-text', this.theme.colors.menuText);
                            document.documentElement.style.setProperty('--fab-menu-hover', this.theme.colors.menuHover);
                            document.documentElement.style.setProperty('--fab-menu-item-accent', this.theme.colors.menuItemAccent);
                            document.documentElement.style.setProperty('--fab-tooltip-bg', this.theme.colors.tooltipBg);
                        }
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
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
                    // Update animation order for items
                    this.$el.querySelectorAll('.menu-item').forEach((item, index) => {
                        item.style.setProperty('--animation-order', index);
                    });
    
                    // Reinitialize radial menu if needed
                    if (this.menuDisplay === 'radial') {
                        this.initRadialMenu();
                    }
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
                :style="{ width: open && menuDisplay === 'horizontal' ? theme.menuWidth : theme.buttonSize }">
                <!-- Main Button -->
                <button class="floating-button group" @click="toggleMenu" :class="{ 'active': open }"
                    :style="{ width: theme.buttonSize, height: theme.buttonSize }">
                    <x-filament::icon icon="heroicon-o-plus" class="icon" />
                    @if ($showTooltip)
                        <span class="fab-tooltip">{{ __('filament-fab::actions.quick_actions') }}</span>
                    @endif
                </button>

                <!-- Menu Items -->
                <div x-show="open" x-cloak class="menu-items"
                    :class="{
                        'active': open,
                        'flex-row': menuDisplay === 'horizontal',
                        'flex-col': menuDisplay === 'vertical',
                        'fab-radial': menuDisplay === 'radial'
                    }"
                    :style="{
                        height: menuDisplay === 'horizontal' ? theme.buttonSize : 'auto',
                        gap: theme.menuSpacing,
                        width: menuDisplay === 'vertical' ? theme.menuItemSize : (menuDisplay === 'horizontal' ?
                            'auto' : '0')
                    }">
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

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('floatingActionButton', (config = {}) => ({
            // ... existing Alpine data ...
            menuDisplay: @js($menuDisplay),
            // ... rest of Alpine data ...
        }));
    });
</script>
