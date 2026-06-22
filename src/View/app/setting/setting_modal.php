<!-- EDIT PROFILE MODAL -->
<div class="pin-modal-overlay" id="editProfileModal">
  <form action="/profile/update" method="POST" class="pin-modal">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <button type="button" onclick="closeModal('editProfileModal')" class="btn-pin-ghost p-1"><i class="bi bi-x-lg"></i></button>
      <h6 style="font-family:'Syne',sans-serif;font-weight:700;margin:0;">Edit Profil</h6>
      <button type="submit" class="btn btn-pin btn-sm">Simpan</button>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label-pin">Nama</label>
      <input type="text" name="name" id="name" class="pin-input" value="<?= $data["user"]["name"] ?>">
    </div>
    <div class="mb-3">
      <label for="bio" class="form-label-pin">Bio</label>
      <textarea class="pin-input" name="bio" id="bio" rows="3"><?= $data["user"]["bio"] ?></textarea>
    </div>
  </form>
</div>

<!-- PASSWORD MODAL -->
<div class="pin-modal-overlay" id="passwordModal">

  <form action="/profile/update-password" method="POST" class="pin-modal">

    <div class="d-flex align-items-center justify-content-between mb-4">

      <button type="button" onclick="closeModal('passwordModal')" class="btn-pin-ghost p-1">

        <i class="bi bi-x-lg"></i>

      </button>

      <h6 style="
          font-family:'Syne',sans-serif;
          font-weight:700;
          margin:0;
        ">
        Ubah Password
      </h6>

      <button type="submit" class="btn btn-pin btn-sm">

        Simpan

      </button>

    </div>

    <div class="mb-3">

      <label class="form-label-pin">
        Password Lama
      </label>

      <input type="password" name="old_password" class="pin-input" placeholder="Masukkan password lama">

    </div>

    <div class="mb-3">

      <label class="form-label-pin">
        Password Baru
      </label>

      <input type="password" name="new_password" class="pin-input" placeholder="Masukkan password baru">

    </div>

    <div>

      <label class="form-label-pin">
        Confirm Password
      </label>

      <input type="password" name="confirm_password" class="pin-input" placeholder="Konfirmasi password">

    </div>

  </form>

</div>