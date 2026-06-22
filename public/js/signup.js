function checkUsername(input) {
  const val = input.value.trim();
  const el = document.getElementById("usernameStatus");
  if (!val) {
    el.textContent = "";
    return;
  }
  const taken = ["admin", "pinthread", "user", "test"];
  if (taken.includes(val.toLowerCase())) {
    el.style.color = "#ff4d6d";
    el.textContent = "✗ Username sudah digunakan";
  } else if (val.length < 3) {
    el.style.color = "var(--pin-muted)";
    el.textContent = "Username minimal 3 karakter";
  } else {
    el.style.color = "#4ade80";
    el.textContent = "✓ Username tersedia";
  }
}
function checkStrength(val) {
  const fill = document.getElementById("strengthFill");
  const label = document.getElementById("strengthLabel");
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const levels = [
    { w: "0%", c: "transparent", t: "Masukkan kata sandi" },
    { w: "25%", c: "#ff4d6d", t: "Lemah" },
    { w: "50%", c: "#fb923c", t: "Cukup" },
    { w: "75%", c: "#facc15", t: "Baik" },
    { w: "100%", c: "#4ade80", t: "Sangat kuat" },
  ];
  const l = val.length === 0 ? levels[0] : levels[Math.max(1, score)];
  fill.style.width = l.w;
  fill.style.background = l.c;
  label.style.color = l.c === "transparent" ? "var(--pin-muted)" : l.c;
  label.textContent = l.t;
}