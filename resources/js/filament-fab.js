/**
 * Filament FAB - Floating Action Button
 */

document.addEventListener('DOMContentLoaded', function () {
    // Listen for FAB action clicks
    document.querySelectorAll('.fab-action').forEach(action => {
        action.addEventListener('click', function (event) {
            const actionName = event.currentTarget.dataset.action;
            // Dispatch an event that can be listened to
            document.dispatchEvent(new CustomEvent('fab:action', {
                detail: {
                    action: actionName
                }
            }));
        });
    });
});

// Setup Alpine.js component if available
if (window.Alpine) {
    window.Alpine.data('floatingActionButton', (config = {}) => ({
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

        init() {
            // Set default config if not provided
            config = config || {};
            const defaultPosition = config.defaultPosition || 'bottom-right';
            const rememberPosition = config.rememberPosition !== undefined ? config.rememberPosition : true;

            const defaultPos = this.getDefaultPositionCoordinates(defaultPosition);

            // Load saved position from localStorage if enabled
            if (rememberPosition) {
                const savedPosition = JSON.parse(localStorage.getItem('FAB-position'));
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
        },

        getDefaultPositionCoordinates(position) {
            const margin = 20;
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
            // Save position to localStorage if remember position is enabled
            if (config.rememberPosition !== false) {
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
    }));
} 