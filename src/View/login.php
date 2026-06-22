<div class="auth-page">
  <!-- Art side -->
  <div class="auth-art">
    <div class="art-glow"></div>
    <div class="art-quote">
      Suara kamu
      <span>penting.</span>
    </div>
    <p class="art-sub">Bergabunglah dengan jutaan orang yang<br>berbagi cerita setiap hari.</p>
  </div>

  <!-- Form side -->
  <div class="auth-form-side">
    <div class="auth-box">
      <h1 class="auth-title">Selamat datang kembali</h1>
      <p class="auth-sub">Masuk untuk melanjutkan perjalananmu.</p>
      <?php if (!empty($data["error_message"])): ?>
        <div
          style="background-color:#fee;border:1px solid #fcc;color:#c33;padding:12px;border-radius:6px;margin-bottom:20px;font-size:14px;">
          <i class="bi bi-exclamation-circle" style="margin-right:8px;"></i>
          <?php echo htmlspecialchars($data["error_message"]); ?>
        </div>
      <?php endif; ?>
      <form action="/login" method="POST">
        <div class="mb-4">
          <label class="form-label-pin" for="loginId">username</label>
          <div class="input-group-pin">
            <i class="bi bi-person input-icon"></i>
            <input type="text" class="pin-input" placeholder="johndoe" id="loginId" name="username">
          </div>
        </div>
        <div class="mb-2 mb-4">
          <label class="form-label-pin" for="loginPass">Kata sandi</label>
          <div class="input-group-pin">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" class="pin-input" placeholder="••••••••" id="loginPass" name="password"
              style="padding-right:44px;">
            <button type="button" class="input-toggle" onclick="togglePass()">
              <i class="bi bi-eye" id="passIcon"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn btn-pin w-100" style="font-size:15px;padding:13px;">
          Masuk
        </button>
      </form>

      <div class="auth-footer">
        Belum punya akun? <a href="/signup">Daftar sekarang</a>
      </div>
    </div>
  </div>
</div>

<script src="/public/js/login.js"></script>