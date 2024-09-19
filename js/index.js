// Toggle Sidebar
document.getElementById("sidebarToggle").addEventListener("click", function () {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("active");

  // Change Icon when sidebar is toggled
  const toggleIcon = this.querySelector("i");
  if (sidebar.classList.contains("active")) {
    toggleIcon.classList.remove("fa-bars");
    toggleIcon.classList.add("fa-times"); // Icon for closed state
  } else {
    toggleIcon.classList.remove("fa-times");
    toggleIcon.classList.add("fa-bars"); // Icon for open state
  }
});

// Folder collapse/expand functionality
const folders = document.querySelectorAll(".folder-toggle");
folders.forEach((folder) => {
  folder.addEventListener("click", function () {
    const folderContent = this.nextElementSibling;
    folderContent.style.display =
      folderContent.style.display === "none" ||
      folderContent.style.display === ""
        ? "block"
        : "none";
  });
});

// Load content dynamically
function loadContent(page) {
  console.log(`Navigating to: ${page}`)
  $("#mainContent").load(page, function (response, status, xhr) {
    if (status == "error") {
      $(this).html(`<h3>Error loading content</h3><p>Trying to nagigate to ${page}</p>`);
    }
  });
}
