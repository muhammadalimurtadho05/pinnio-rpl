function switchTab(el) {
  document
    .querySelectorAll(".pin-tab")
    .forEach((t) => t.classList.remove("active"));
  el.classList.add("active");
}

function togglePostMenu(btn) {
  const menu = btn.nextElementSibling;
  const isOpen = menu.style.display !== "none";

  // Close all other open menus
  document.querySelectorAll(".post-menu").forEach((m) => {
    if (m !== menu) m.style.display = "none";
  });

  // Toggle current menu
  menu.style.display = isOpen ? "none" : "block";
}

let pendingDeleteMemeId = null;

function deletePost(memeId) {
  // Store the meme ID and open confirmation modal
  pendingDeleteMemeId = memeId;
  openModal("deletePostModal");
}

function confirmDeletePost() {
  if (!pendingDeleteMemeId) return;

  const memeId = pendingDeleteMemeId;
  closeModal("deletePostModal");

  // Send delete request to server
  fetch(`/meme/delete/${memeId}`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.ok) {
        showToast("Postingan berhasil dihapus!", "success");
        // Reload page or remove the post from DOM
        setTimeout(() => location.reload(), 500);
      } else {
        showToast("Gagal menghapus postingan", "error");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showToast("Terjadi kesalahan", "error");
    });

  pendingDeleteMemeId = null;
}

// Close menu when clicking outside
document.addEventListener("click", (e) => {
  if (!e.target.closest(".post-menu-wrapper")) {
    document.querySelectorAll(".post-menu").forEach((menu) => {
      menu.style.display = "none";
    });
  }
});
