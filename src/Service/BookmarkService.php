<?php

namespace App\Pinnio\Service;

use App\Pinnio\Repository\BookmarkRepository;
use App\Pinnio\Exception\ValidationException;

class BookmarkService
{
  private static BookmarkRepository $bookmarkRepository;

  public function __construct(BookmarkRepository $bookmarkRepository)
  {
    self::$bookmarkRepository = $bookmarkRepository;
  }

  public function toggleBookmark(int $userID, int $memeID): array
  {
    $bookmarkedMemeIds = self::$bookmarkRepository->getBookmarkedMemeIds($userID);
    $isBookmarked = in_array($memeID, $bookmarkedMemeIds);

    if ($isBookmarked) {
      self::$bookmarkRepository->removeBookmark($userID, $memeID);
      return ["status" => "removed"];
    } else {
      self::$bookmarkRepository->addBookmark($userID, $memeID);
      return ["status" => "added"];
    }
  }

  public function getBookmarkedMemes(int $userID): array
  {
    return self::$bookmarkRepository->getBookmarkedMemes($userID);
  }

  public function getBookmarkedMemeIds(int $userID): array
  {
    return self::$bookmarkRepository->getBookmarkedMemeIds($userID);
  }
}
