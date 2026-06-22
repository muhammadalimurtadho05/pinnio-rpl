// ============================================
// PINTHREAD — Shared JS
// ============================================

// Like toggle (AJAX)
document.addEventListener("click", async (e) => {
  const btn = e.target.closest('.thread-action-btn[data-action="like"]');
  if (!btn) return;

  e.preventDefault();

  const memeId = btn.getAttribute("data-meme-id");
  if (!memeId) {
    console.error("data-meme-id attribute not found on like button");
    return;
  }

  const countSpan = btn.querySelector(".action-count");
  const icon = btn.querySelector("i");

  // Disable button click events temporarily to prevent double submission
  btn.style.pointerEvents = "none";

  try {
    const response = await fetch("/meme/like", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ meme_id: memeId }),
    });

    const data = await response.json();

    if (response.ok) {
      // 1. Update the total likes count
      if (countSpan) {
        countSpan.textContent = data.likes_count;
      }

      // 2. Toggle visual styles (icon classes and 'liked' color class)
      if (data.status === "liked") {
        btn.classList.add("liked");
        if (icon) {
          icon.classList.remove("bi-heart");
          icon.classList.add("bi-heart-fill");
        }
      } else {
        btn.classList.remove("liked");
        if (icon) {
          icon.classList.remove("bi-heart-fill");
          icon.classList.add("bi-heart");
        }
      }
    } else {
      if (typeof showToast === "function") {
        showToast(data.error || "Gagal melakukan aksi like", "error");
      } else {
        alert(data.error || "Gagal melakukan aksi like");
      }
    }
  } catch (error) {
    console.error("Gagal melakukan like:", error);
    if (typeof showToast === "function") {
      showToast("Terjadi kesalahan jaringan", "error");
    }
  } finally {
    // Re-enable button click events
    btn.style.pointerEvents = "auto";
  }
});

// Bookmark toggle (AJAX)
document.addEventListener("click", async (e) => {
  const btn = e.target.closest('.thread-action-btn[data-action="bookmark"]');
  if (!btn) return;

  e.preventDefault();

  const memeId = btn.getAttribute("data-meme-id");
  if (!memeId) {
    console.error("data-meme-id attribute not found on bookmark button");
    return;
  }

  const icon = btn.querySelector("i");
  btn.style.pointerEvents = "none";

  try {
    const response = await fetch("/meme/bookmark", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ meme_id: memeId }),
    });

    const data = await response.json();

    if (response.ok) {
      if (data.status === "added") {
        btn.classList.add("bookmarked");
        if (icon) {
          icon.classList.remove("bi-bookmark");
          icon.classList.add("bi-bookmark-fill");
          icon.style.color = "var(--pin-yellow)";
        }
      } else {
        btn.classList.remove("bookmarked");
        if (icon) {
          icon.classList.remove("bi-bookmark-fill");
          icon.classList.add("bi-bookmark");
          icon.style.color = "";
        }
      }
    } else {
      if (typeof showToast === "function") {
        showToast(data.error || "Gagal melakukan aksi bookmark", "error");
      }
    }
  } catch (error) {
    console.error("Gagal melakukan bookmark:", error);
    if (typeof showToast === "function") {
      showToast("Terjadi kesalahan jaringan", "error");
    }
  } finally {
    btn.style.pointerEvents = "auto";
  }
});

// Clickable thread items (excluding action buttons/links/dropdowns)
document.addEventListener("click", (e) => {
  const thread = e.target.closest(".clickable-thread");
  if (!thread) return;

  // Don't trigger navigation if clicking on interactive elements
  if (
    e.target.closest(".thread-actions") || 
    e.target.closest("button") || 
    e.target.closest("a") || 
    e.target.closest(".action-menu-wrap") ||
    e.target.closest(".dropdown-menu-pin")
  ) {
    return;
  }

  const href = thread.getAttribute("data-href");
  if (href) {
    window.location.href = href;
  }
});

// Follow button toggle (AJAX)
document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".follow-btn");
  if (!btn) return;
  
  e.preventDefault();
  
  const userId = btn.getAttribute("data-user-id");
  if (!userId) {
    console.error("data-user-id attribute not found on follow button");
    return;
  }

  btn.style.pointerEvents = "none";
  const originalText = btn.textContent;
  btn.textContent = "...";

  try {
    const response = await fetch("/user/follow", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ user_id: userId }),
    });

    const data = await response.json();

    if (response.ok && data.success) {
      if (data.status === "followed") {
        btn.textContent = "Following";
        btn.classList.remove("btn-pin");
        btn.classList.add("btn-outline-light");
      } else {
        btn.textContent = "Follow";
        btn.classList.add("btn-pin");
        btn.classList.remove("btn-outline-light");
      }
    } else {
      btn.textContent = originalText;
      if (typeof showToast === "function") {
        showToast(data.message || "Gagal melakukan aksi follow", "error");
      }
    }
  } catch (error) {
    console.error("Gagal melakukan follow:", error);
    btn.textContent = originalText;
    if (typeof showToast === "function") {
      showToast("Terjadi kesalahan jaringan", "error");
    }
  } finally {
    btn.style.pointerEvents = "auto";
  }
});

// Modal helpers
function openModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.add("open");
}
function closeModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.remove("open");
}
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("pin-modal-overlay")) {
    e.target.classList.remove("open");
  }
});

// Textarea auto-resize
document.addEventListener("input", (e) => {
  if (
    e.target.tagName === "TEXTAREA" &&
    e.target.classList.contains("pin-input")
  ) {
    e.target.style.height = "auto";
    e.target.style.height = e.target.scrollHeight + "px";
  }
});

// Fake avatar placeholder generator
function avatarUrl(seed, size = 48) {
  return `https://api.dicebear.com/7.x/thumbs/svg?seed=${seed}&size=${size}`;
}

// Report Logic
function openReportModal(memeId) {
  document.getElementById('reportMemeId').value = memeId;
  document.getElementById('reportReason').value = '';
  openModal('reportModal');
}

async function submitReport() {
  const memeId = document.getElementById('reportMemeId').value;
  const reason = document.getElementById('reportReason').value;

  if (!reason) {
    showToast("Please select a reason.", "error");
    return;
  }

  try {
    const response = await fetch("/meme/report", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ meme_id: memeId, reason: reason }),
    });

    const data = await response.json();

    if (response.ok) {
      showToast(data.message, "success");
      closeModal('reportModal');
    } else {
      showToast(data.message || "Failed to submit report", "error");
    }
  } catch (error) {
    console.error("Error submitting report:", error);
    showToast("Network error occurred", "error");
  }
}

// Simple toast
function showToast(msg, type = "default") {
  let container = document.getElementById("toast-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "toast-container";
    container.style.cssText =
      "position:fixed;bottom:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:8px;";
    document.body.appendChild(container);
  }
  const toast = document.createElement("div");

  let bg, color;
  if (type === "success") {
    bg = "var(--pin-yellow)";
    color = "var(--pin-dark)";
  } else if (type === "error") {
    bg = "#ff4d6d";
    color = "var(--pin-white)";
  } else {
    bg = "var(--pin-card)";
    color = "var(--pin-white)";
  }

  toast.style.cssText = `background:${bg};color:${color};padding:12px 20px;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;border:1px solid var(--pin-border);animation:fadeUp .3s ease;box-shadow:0 8px 24px rgba(0,0,0,0.3);`;
  toast.textContent = msg;
  container.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

function handleImageSelect(event) {
  const file = event.target.files?.[0];
  if (!file) return;

  // Validate file is an image
  if (!file.type.startsWith("image/")) {
    showToast("Pilih file gambar!", "error");
    return;
  }

  // Validate file size (max 5MB)
  const maxSize = 5 * 1024 * 1024; // 5MB
  if (file.size > maxSize) {
    showToast("Ukuran gambar terlalu besar (max 5MB)", "error");
    return;
  }

  // Read and display image
  const reader = new FileReader();
  reader.onload = (e) => {
    const previewContainer = document.getElementById("imagePreviewContainer");
    const previewImg = document.getElementById("imagePreview");
    previewImg.src = e.target.result;
    previewContainer.style.display = "block";
  };
  reader.readAsDataURL(file);
}

function clearImagePreview() {
  document.getElementById("imagePreviewContainer").style.display = "none";
  document.getElementById("imagePreview").src = "";
  document.getElementById("imageCaption").value = "";
  document.getElementById("imageInput").value = "";
}

function postThread() {
  const text = document.getElementById("modalComposeText")?.value;
  const imageInput = document.getElementById("imageInput");
  const imageCaption = document.getElementById("imageCaption")?.value;
  const hasImage = imageInput?.files?.length > 0;

  if (!text?.trim() && !hasImage) {
    showToast("Tulis sesuatu atau pilih gambar!");
    return;
  }

  // Prepare data to send to server
  const formData = new FormData();
  formData.append("text", text || "");
  if (hasImage) {
    formData.append("image", imageInput.files[0]);
    formData.append("caption", imageCaption || "");
  }

  // TODO: Send formData to server endpoint
  // Example: fetch('/api/thread/create', { method: 'POST', body: formData })

  showToast("Thread berhasil dipost!", "success");
  closeModal("composeModal");

  // Reset form
  document.getElementById("modalComposeText").value = "";
  clearImagePreview();
}

function loadMore() {
  showToast("Memuat thread baru...");
}

function votePoll(el, pct) {
  showToast(`Kamu memilih! (${pct}%)`, "success");
}
