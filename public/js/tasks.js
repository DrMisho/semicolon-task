    (() => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const form = document.getElementById('task-form');
    const titleInput = document.getElementById('task-title');
    const errorBanner = document.getElementById('error-banner');
    const activeList = document.getElementById('active-list');
    const completedList = document.getElementById('completed-list');
    const activeCount = document.getElementById('active-count');
    const completedCount = document.getElementById('completed-count');
    const activeEmpty = document.getElementById('active-empty');
    const completedEmpty = document.getElementById('completed-empty');
    const completedDropzone = document.getElementById('completed-dropzone');

    let tasks = [];
    let completingIds = new Set();

    function showError(message) {
        errorBanner.hidden = false;
        errorBanner.textContent = message;
    }

    function clearError() {
        errorBanner.hidden = true;
        errorBanner.textContent = '';
    }

    async function api(url, options = {}) {
        const response = await fetch(url, {
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                ...(options.headers || {}),
            },
            credentials: 'same-origin',
            ...options,
        });

        let data = null;
        const text = await response.text();
        if (text) {
            try {
                data = JSON.parse(text);
            } catch {
                data = null;
            }
        }

        if (!response.ok) {
            const message =
                data?.message ||
                (data?.errors && Object.values(data.errors).flat()[0]) ||
                `Request failed (${response.status})`;
            throw new Error(message);
        }

        return data;
    }

    function createTaskElement(task) {
        const li = document.createElement('li');
        li.className = `task-item ${task.completed ? 'is-completed' : 'is-active'}`;
        li.dataset.id = String(task.id);
        li.setAttribute('role', 'listitem');

        if (!task.completed) {
            li.draggable = true;
            li.title = 'Click to complete, or drag to Completed';
        }

        const check = document.createElement('span');
        check.className = 'task-check';
        check.setAttribute('aria-hidden', 'true');

        const title = document.createElement('p');
        title.className = 'task-title';
        title.textContent = task.title;

        li.append(check, title);

        if (!task.completed) {
            li.addEventListener('click', () => completeTask(task.id));

            li.addEventListener('dragstart', (event) => {
                li.classList.add('is-dragging');
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', String(task.id));
            });

            li.addEventListener('dragend', () => {
                li.classList.remove('is-dragging');
                completedDropzone.classList.remove('is-drop-target');
            });
        }

        return li;
    }

    function render() {
        const active = tasks.filter((task) => !task.completed);
        const completed = tasks.filter((task) => task.completed);

        activeList.replaceChildren(...active.map(createTaskElement));
        completedList.replaceChildren(...completed.map(createTaskElement));

        activeCount.textContent = String(active.length);
        completedCount.textContent = String(completed.length);
        activeEmpty.hidden = active.length > 0;
        completedEmpty.hidden = completed.length > 0;
    }

    async function loadTasks() {
        clearError();
        try {
            tasks = await api('/tasks');
            render();
        } catch (error) {
            showError(error.message || 'Could not load tasks.');
        }
    }

    async function completeTask(id) {
        if (completingIds.has(id)) {
            return;
        }

        const task = tasks.find((item) => item.id === id);
        if (!task || task.completed) {
            return;
        }

        completingIds.add(id);
        clearError();

        try {
            const updated = await api(`/tasks/${id}`, { method: 'PATCH', body: '{}' });
            tasks = tasks.map((item) => (item.id === id ? updated : item));
            render();
        } catch (error) {
            showError(error.message || 'Could not complete task.');
        } finally {
            completingIds.delete(id);
        }
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearError();

        const title = titleInput.value.trim();
        if (!title) {
            showError('The title field is required.');
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        try {
            const created = await api('/tasks', {
                method: 'POST',
                body: JSON.stringify({ title }),
            });
            tasks = [created, ...tasks];
            titleInput.value = '';
            titleInput.focus();
            render();
        } catch (error) {
            showError(error.message || 'Could not create task.');
        } finally {
            submitButton.disabled = false;
        }
    });

    ['dragover', 'dragenter'].forEach((eventName) => {
        completedDropzone.addEventListener(eventName, (event) => {
            event.preventDefault();
            completedDropzone.classList.add('is-drop-target');
            if (event.dataTransfer) {
                event.dataTransfer.dropEffect = 'move';
            }
        });
    });

    completedDropzone.addEventListener('dragleave', (event) => {
        if (!completedDropzone.contains(event.relatedTarget)) {
            completedDropzone.classList.remove('is-drop-target');
        }
    });

    completedDropzone.addEventListener('drop', (event) => {
        event.preventDefault();
        completedDropzone.classList.remove('is-drop-target');
        const id = Number(event.dataTransfer.getData('text/plain'));
        if (id) {
            completeTask(id);
        }
    });

    loadTasks();
})();
