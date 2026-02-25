document.addEventListener('DOMContentLoaded', () => {
    const buttons = [
        document.getElementById('floating-whatsapp-btn'),
        document.getElementById('floating-phone-btn')
    ];

    buttons.forEach(btn => {
        if (!btn) return;

        const id = btn.id;
        let isDragging = false;
        let startX, startY, initialLeft, initialTop;
        let hasMoved = false;

        // Restore saved position
        const savedPos = localStorage.getItem(id);
        if (savedPos) {
            try {
                const pos = JSON.parse(savedPos);
                btn.style.left = pos.left;
                btn.style.top = pos.top;
                btn.style.bottom = 'auto';
                btn.style.right = 'auto';
            } catch (e) {
                console.error('Error parsing saved position', e);
            }
        }

        const onStart = (clientX, clientY) => {
            isDragging = true;
            hasMoved = false;
            startX = clientX;
            startY = clientY;

            const rect = btn.getBoundingClientRect();
            initialLeft = rect.left;
            initialTop = rect.top;

            // Switch to fixed left/top positioning
            btn.style.left = `${initialLeft}px`;
            btn.style.top = `${initialTop}px`;
            btn.style.bottom = 'auto';
            btn.style.right = 'auto';

            // Add grabbing cursor
            btn.style.cursor = 'grabbing';
        };

        const onMove = (clientX, clientY) => {
            if (!isDragging) return;

            const dx = clientX - startX;
            const dy = clientY - startY;

            // Consider it a move if dragged more than 5px
            if (Math.abs(dx) > 5 || Math.abs(dy) > 5) {
                hasMoved = true;
            }

            let newLeft = initialLeft + dx;
            let newTop = initialTop + dy;

            // Constrain to viewport
            const maxLeft = window.innerWidth - btn.offsetWidth;
            const maxTop = window.innerHeight - btn.offsetHeight;

            newLeft = Math.max(0, Math.min(newLeft, maxLeft));
            newTop = Math.max(0, Math.min(newTop, maxTop));

            btn.style.left = `${newLeft}px`;
            btn.style.top = `${newTop}px`;
        };

        const onEnd = () => {
            if (!isDragging) return;
            isDragging = false;
            btn.style.cursor = 'move';

            if (hasMoved) {
                // Save position
                localStorage.setItem(id, JSON.stringify({
                    left: btn.style.left,
                    top: btn.style.top
                }));
            }
        };

        // Mouse Events
        btn.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return; // Left click only
            e.preventDefault(); // Prevent text selection
            onStart(e.clientX, e.clientY);
        });

        window.addEventListener('mousemove', (e) => {
            if (isDragging) {
                e.preventDefault();
                onMove(e.clientX, e.clientY);
            }
        });

        window.addEventListener('mouseup', (e) => {
            onEnd();
        });

        // Touch Events
        btn.addEventListener('touchstart', (e) => {
            // We prevent default to stop scrolling, but this kills the 'click' event.
            // We must manually trigger click if it wasn't a drag.
            e.preventDefault();
            const touch = e.touches[0];
            onStart(touch.clientX, touch.clientY);
        }, { passive: false });

        window.addEventListener('touchmove', (e) => {
            if (isDragging) {
                // Prevent scrolling while dragging
                e.preventDefault();
                const touch = e.touches[0];
                onMove(touch.clientX, touch.clientY);
            }
        }, { passive: false });

        window.addEventListener('touchend', (e) => {
            if (isDragging) {
                // If we didn't move significantly, treat it as a click
                if (!hasMoved) {
                    const link = btn.querySelector('a');
                    if (link) {
                        // Use window.open for target blank if needed, or location.href
                        // but link.click() is best to simulate native behavior
                        // However, preventDefault on touchstart might mess with some browsers.
                        // Let's try explicit navigation.
                        const href = link.getAttribute('href');
                        const target = link.getAttribute('target');

                        if (target === '_blank') {
                            window.open(href, '_blank');
                        } else {
                            window.location.href = href;
                        }
                    }
                }
                onEnd();
            }
        });

        // Handle click event just in case (e.g. keyboard navigation or if mouse didn't prevent default)
        btn.addEventListener('click', (e) => {
            if (hasMoved) {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        }, true); // Capture phase
    });
});
