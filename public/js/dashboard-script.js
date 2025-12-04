const sidebar = document.querySelector("#sidebar");
const toggleBtns = document.querySelectorAll(".toggle-btn"); // Changed to querySelectorAll
const overlay = document.querySelector(".sidebar-overlay");

function toggleSidebar() {
    sidebar.classList.toggle("expand");
    overlay.classList.toggle("active");
}

// Add event listener to all toggle buttons
if (toggleBtns.length) {
    toggleBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            toggleSidebar();
        });
    });
}

if (overlay) {
    overlay.addEventListener("click", function () {
        toggleSidebar();
    });
}


// Display current date
const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
const currentDateEl = document.getElementById('currentDate');
if(currentDateEl) {
    currentDateEl.textContent = new Date().toLocaleDateString('id-ID', options);
}
