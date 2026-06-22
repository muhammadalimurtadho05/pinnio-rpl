<div class="auth-page">
  <!-- Art side -->
  <div class="auth-art">
    <div class="art-glow"></div>
    <div style="position:relative;z-index:1;text-align:center;margin-bottom:40px;">
      <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:36px;letter-spacing:-1px;line-height:1.1;">
        Mulai dalam<br><span style="color:var(--pin-yellow)">3 langkah</span>
      </div>
    </div>
    <ul class="steps-list">
      <li>
        <div class="step-num">1</div>
        <div>
          <div style="font-weight:600;">Buat akun</div>
          <div style="color:var(--pin-muted);font-size:12px;margin-top:2px;">Isi info dasar kamu</div>
        </div>
      </li>
      <li>
        <div class="step-num">2</div>
        <div>
          <div style="font-weight:600;">Log in</div>
          <div style="color:var(--pin-muted);font-size:12px;margin-top:2px;">Melakukan autentikasi</div>
        </div>
      </li>
      <li>
        <div class="step-num">3</div>
        <div>
          <div style="font-weight:600;">Mulai ngethread!</div>
          <div style="color:var(--pin-muted);font-size:12px;margin-top:2px;">Bagikan ceritamu ke dunia</div>
        </div>
      </li>
    </ul>
  </div>

  <!-- Form side -->
  <div class="auth-form-side">
    <div class="auth-box">
      <h1 class="auth-title">Buat akun baru</h1>
      <p class="auth-sub">Bergabung dengan komunitas PinThread hari ini.</p>
      <?php if (!empty($data["error_message"])): ?>
        <div
          style="background-color:#fee;border:1px solid #fcc;color:#c33;padding:12px;border-radius:6px;margin-bottom:20px;font-size:14px;">
          <i class="bi bi-exclamation-circle"
            style="margin-right:8px;"></i><?php echo htmlspecialchars($data["error_message"]); ?>
        </div>
      <?php endif; ?>
      <form action="/signup" method="POST">
        <div class="mb-3">
          <label class="form-label-pin" for="username">Username</label>
          <div class="input-group-pin">
            <i class="bi bi-at input-icon"></i>
            <input type="text" class="pin-input" placeholder="johndoe" id="username" name="username"
              oninput="checkUsername(this)">
          </div>
          <div id="usernameStatus" style="font-size:12px;margin-top:6px;"></div>
        </div>
        <div class="mb-3">
          <label class="form-label-pin" for="email">Email</label>
          <div class="input-group-pin">
            <i class="bi bi-envelope input-icon"></i>
            <input type="email" class="pin-input" placeholder="email@kamu.com" id="email" name="email">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label-pin" for="password">Kata sandi</label>
          <div class="input-group-pin">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" class="pin-input" placeholder="Minimal 8 karakter" id="password" name="password"
              oninput="checkStrength(this.value)">
          </div>
          <div class="pass-strength">
            <div class="strength-bar">
              <div class="strength-fill" id="strengthFill"></div>
            </div>
            <div class="strength-label" id="strengthLabel">Masukkan kata sandi</div>
          </div>
        </div>
        <button type="submit" class="btn btn-pin w-100" style="font-size:15px;padding:13px;">
          Buat Akun
        </button>
      </form>

      <div class="auth-footer">
        Sudah punya akun? <a href="/login">Masuk</a>
      </div>
    </div>
  </div>
</div>
<script src="/public/js/signup.js"></script>