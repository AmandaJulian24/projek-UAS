document.addEventListener("DOMContentLoaded", () => {
    const taskForm = document.getElementById("taskForm");
    const taskList = document.getElementById("taskList");

    // Fetch data awal
    fetchTasks();

    // Tambah tugas
    taskForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const taskName = document.getElementById("taskName").value;
        const taskDescription = document.getElementById("taskDescription").value;

        fetch("/api/todo_api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ task_name: taskName, description: taskDescription })
        }).then(() => {
            fetchTasks();
            taskForm.reset();
        });
    });

    // Fetch tugas dari API
    function fetchTasks() {
        fetch("/api/todo_api.php")
            .then((response) => response.json())
            .then((tasks) => {
                taskList.innerHTML = tasks.map(task => `
                    <li>
                        ${task.task_name} - ${task.status}
                        <button onclick="deleteTask(${task.id})">Delete</button>
                    </li>
                `).join("");
            });
    }

    // Hapus tugas
    window.deleteTask = function (id) {
        fetch("/api/todo_api.php", {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: id })
        }).then(() => fetchTasks());
    };
});
