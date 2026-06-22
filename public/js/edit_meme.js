function updateCounter() {
  const input = document.getElementById("editPostInput");

  document.getElementById("charCount").innerText = input.value.length;
}

function savePost() {
  const text = document.getElementById("editPostInput").value;

  if (text.trim() === "") {
    showToast("Postingan tidak boleh kosong!");
    return;
  }

  showToast("Postingan berhasil diperbarui!", "success");

  setTimeout(() => {
    window.location = "thread-view.html";
  }, 1200);
}
