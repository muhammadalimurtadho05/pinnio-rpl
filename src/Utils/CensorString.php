<?php

namespace App\Pinnio\Utils;

class CensorString
{
  private static ?array $badWords = null;

  /**
   * Memuat daftar kata kotor dari file bad_words.php
   */
  private static function loadBadWords(): array
  {
    if (self::$badWords === null) {
      // Sesuaikan path ke file bad_words.php Anda
      // Asumsi letak file: src/Config/bad_words.php atau root
      $path = __DIR__ . "/../Config/bad_words.php";

      if (file_exists($path)) {
        require_once $path;
        // Mengambil variabel global $BAD_WORDS dari file tersebut
        self::$badWords = $BAD_WORDS ?? [];
      } else {
        self::$badWords = [];
      }
    }
    return self::$badWords;
  }

  /**
   * Mengganti kata-kata kotor dengan tanda bintang (*)
   */
  public static function filter(string $text): string
  {
    $words = self::loadBadWords();
    if (empty($words)) {
      return $text;
    }

    foreach ($words as $word) {
      // Trim jika ada spasi tidak sengaja di kamus
      $word = trim($word);
      if (empty($word))
        continue;

      // Membuat pola regex case-insensitive untuk menyensor kata tersebut
      // preg_quote digunakan agar karakter spesial seperti * atau ! di leetspeak tidak merusak regex
      $pattern = '/' . preg_quote($word, '/') . '/i';

      $text = preg_replace_callback($pattern, function ($matches) {
        return str_repeat('*', strlen($matches[0]));
      }, $text);
    }

    return $text;
  }
}