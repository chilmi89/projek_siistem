const draggables = document.querySelectorAll('.balok');

draggables.forEach(draggable => {
    let isDragging = false;
    let offsetX, offsetY;

    draggable.addEventListener('mousedown', (e) => {
        isDragging = true;
        offsetX = e.clientX - draggable.getBoundingClientRect().left;
        offsetY = e.clientY - draggable.getBoundingClientRect().top;
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
    });

    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            draggable.style.left = e.clientX - offsetX + 'px';
            draggable.style.top = e.clientY - offsetY + 'px';
        }
    });

    
    window.addEventListener('touchstart', (e) => {
        const touch = e.touches[0];
        isDragging = true;
        offsetX = touch.pageX - draggable.offsetLeft;
        offsetY = touch.pageY - draggable.offsetTop;
        offsetX = touch.clientX - draggable.getBoundingClientRect().left;
        offsetY = touch.clientY - draggable.getBoundingClientRect().top;
    });

    window.addEventListener('touchend', () => {
        isDragging = false;
    });

    window.addEventListener('touchmove', (e) => {
        if (isDragging) {
            const touch = e.touches[0];
            draggable.style.left = touch.pageX - offsetX + 'px';
            draggable.style.top = touch.pageY - offsetY + 'px';
            draggable.style.left = touch.clientX - offsetX + 'px';
            draggable.style.top = touch.clientY - offsetY + 'px';
        }
    });

    // draggable.addEventListener('click', (e) => {
    //     if (!isDragging) {
    //         alert('klik');
    //     }
    // });
});
