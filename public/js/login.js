function togglePass() {
  const input = document.getElementById("loginPass");
  const icon = document.getElementById("passIcon");
  if (input.type === "password") {
    input.type = "text";
    icon.className = "bi bi-eye-slash";
  } else {
    input.type = "password";
    icon.className = "bi bi-eye";
  }
}
function handleLogin(e) {
  e.preventDefault();
  const id = document.getElementById("loginId").value;
  const pass = document.getElementById("loginPass").value;
  if (!id || !pass) {
    showToast("Lengkapi semua field");
    return;
  }
  showToast("Masuk berhasil!", "success");
  setTimeout(() => (window.location.href = "home.html"), 1000);
}
