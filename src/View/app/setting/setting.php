<div class="main-content">

  <div class="feed-col">

    <!-- PAGE HEADER -->
    <div class="page-header">

      <div style="
            font-family:'Syne',sans-serif;
            font-weight:800;
            font-size:18px;
          ">
        Pengaturan
      </div>

    </div>

    <!-- ACCOUNT -->
    <div class="pin-card p-4 mb-4">

      <h5 class="mb-4" style="font-family:'Syne',sans-serif;font-weight:700;">

        Akun Saya

      </h5>

      <!-- EDIT PROFILE -->
      <div class="mb-4 pb-4" style="border-bottom:1px solid var(--pin-border);">

        <div class="d-flex justify-content-between align-items-center">

          <div>

            <div style="font-weight:600;">
              Edit Profil
            </div>

            <div style="
                  font-size:13px;
                  color:var(--pin-muted);
                ">
              Ubah nama, bio, dan informasi akun
            </div>

          </div>

          <button class="btn btn-pin-outline btn-sm" onclick="openModal('editProfileModal')">

            Edit

          </button>

        </div>

      </div>

      <!-- PASSWORD -->
      <div class="d-flex justify-content-between align-items-center">

        <div>

          <div style="font-weight:600;">
            Ubah Password
          </div>

          <div style="
                font-size:13px;
                color:var(--pin-muted);
              ">
            Ganti password akun kamu
          </div>

        </div>

        <button class="btn btn-pin-outline btn-sm" onclick="openModal('passwordModal')">

          Ubah

        </button>

      </div>

    </div>

    <!-- LOGOUT -->
    <div class="pin-card p-4 mb-5">

      <h5 class="mb-4" style="font-family:'Syne',sans-serif;font-weight:700;color:#ff6b6b;">

        Logout

      </h5>

      <div class="d-flex justify-content-between align-items-center">

        <div>

          <div style="font-weight:600;">
            Keluar dari akun
          </div>

          <div style="
                font-size:13px;
                color:var(--pin-muted);
            ">
            Kamu harus login kembali untuk masuk
          </div>

        </div>

        <a href="/logout" class="btn btn-danger rounded-pill px-4">

          Logout

        </a>

      </div>

    </div>

  </div>

</div>

</div>