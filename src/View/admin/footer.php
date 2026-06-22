      </main>
    </div>
  </div>

  <script src="/public/js/bootstrap.bundle.min.js"></script>
  <script src="/public/js/app.js"></script>
  <?php if (isset($data["error_message"])): ?>
    <script>
      showToast("<?= $data["error_message"] ?>", "error")
    </script>
  <?php endif ?>
  <?php if (isset($data["script"])): ?>
    <?php foreach ($data["script"] as $script): ?>
      <script src="/public/js/<?= $script ?>"></script>
    <?php endforeach ?>
  <?php endif ?>
</body>
</html>
