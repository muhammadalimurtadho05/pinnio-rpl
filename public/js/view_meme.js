// ---- Dropdown helpers ----
function toggleDropdown(id) {
  const all = document.querySelectorAll(".dropdown-menu-pin");
  all.forEach((d) => {
    if (d.id !== id) d.classList.remove("show");
  });
  document.getElementById(id)?.classList.toggle("show");
}
function closeDropdown(id) {
  document.getElementById(id)?.classList.remove("show");
}
// Close dropdown on outside click
document.addEventListener("click", (e) => {
  if (!e.target.closest(".action-menu-wrap")) {
    document
      .querySelectorAll(".dropdown-menu-pin")
      .forEach((d) => d.classList.remove("show"));
  }
});

// ---- Comment submit ----
function submitComment() {
  const input = document.getElementById("commentInput");
  const text = input?.value?.trim();
  if (!text) {
    showToast("Tulis komentar dulu!");
    return;
  }

  const container = document.getElementById("commentsContainer");
  const newComment = document.createElement("div");
  newComment.className = "comment-item fade-up";
  newComment.innerHTML = `
        <div class="d-flex gap-3">
          <div style="width:40px;height:40px;border-radius:50%;background:var(--pin-card);border:1.5px solid var(--pin-border);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">🙂</div>
          <div class="flex-grow-1">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <div>
                <span style="font-weight:700;font-size:14px;">Anya Kartika</span>
                <span class="ms-1" style="font-size:11px;color:var(--pin-yellow);font-weight:600;">Kamu</span>
                <span style="color:var(--pin-muted);font-size:12px;margin-left:6px;">· Baru saja</span>
              </div>
              <div class="action-menu-wrap">
                <button class="btn-pin-ghost p-1" onclick="toggleDropdown('newCommentDrop')"><i class="bi bi-three-dots"></i></button>
                <div class="dropdown-menu-pin" id="newCommentDrop">
                  <button class="dropdown-item-pin danger" onclick="closeDropdown('newCommentDrop'); openModal('deleteCommentModal')">
                    <i class="bi bi-trash3"></i> Hapus komentar
                  </button>
                </div>
              </div>
            </div>
            <p style="font-size:14px;margin-bottom:10px;">${text.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</p>
            <div class="thread-actions">
              <button class="thread-action-btn" data-action="like"><i class="bi bi-heart"></i><span class="action-count">0</span></button>
            </div>
          </div>
        </div>
      `;
  container.insertBefore(newComment, container.firstChild);
  input.value = "";
  input.style.height = "auto";

  // Update comment count
  const countEl = document.querySelector(".post-stat:nth-child(2) span");
  if (countEl) countEl.textContent = parseInt(countEl.textContent) + 1;

  showToast("Komentar berhasil dikirim!", "success");
}

// Submit on Ctrl+Enter
document.getElementById("commentInput")?.addEventListener("keydown", (e) => {
  if (e.key === "Enter" && e.ctrlKey) submitComment();
});

// ---- Reply helper ----
function replyTo(name) {
  const input = document.getElementById("commentInput");
  if (!input) return;
  input.focus();
  if (!input.value.startsWith(`@`)) {
    input.value = `@${name.replace(" ", "").toLowerCase()} `;
  }
  input.scrollIntoView({ behavior: "smooth", block: "center" });
}

// ---- Focus comment box ----
function focusCommentBox() {
  document.getElementById("commentInput")?.focus();
  document
    .getElementById("commentSection")
    ?.scrollIntoView({ behavior: "smooth", block: "center" });
}

// ---- Delete post ----
function confirmDeletePost() {
  closeModal("deletePostModal");
  showToast("Thread berhasil dihapus!", "success");
  setTimeout(() => {
    window.location.href = "home.html";
  }, 1200);
}

// ---- Delete comment ----
function confirmDeleteComment() {
  closeModal("deleteCommentModal");
  showToast("Komentar berhasil dihapus!", "success");
}

// ---- Misc ----
function postThread() {
  const text = document.getElementById("modalComposeText")?.value;
  if (!text?.trim()) {
    showToast("Tulis sesuatu dulu!");
    return;
  }
  showToast("Thread berhasil dipost!", "success");
  closeModal("composeModal");
  document.getElementById("modalComposeText").value = "";
}

function copyLink() {
  showToast("Tautan disalin!", "success");
}
function pinPost() {
  showToast("Thread disematkan ke profil!", "success");
}
function editPost() {
  showToast("Fitur edit segera hadir...");
}
function loadMoreComments() {
  showToast("Memuat komentar...");
}