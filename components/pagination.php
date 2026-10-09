<?php

require_once __DIR__ . "/../back/getStudents.php";

$pagesNumber = ceil(getStudentsCount() / 10);
$currentPage = 1;

if (isset($_GET['page']) && $_GET['page'] > 1) {
  $currentPage = $_GET['page'];
}

$liHTML = "";

for ($i = 0; $i <= $pagesNumber + 1; $i++) {
  if ($i == 0) {
    $isDisabled = ($currentPage == 1) ? 'disabled' : "";
    $prevPage = ($currentPage == 1) ? 1 : $currentPage - 1;
    $liHTML .= "<li class='page-item'><a class='page-link {$isDisabled}' href='#' page={$prevPage}'>Previous</a></li>";
  } else if ($i == $pagesNumber + 1) {
    $isDisabled = ($currentPage == $pagesNumber) ? 'disabled' : "";
    $nextPage = ($currentPage == $pagesNumber) ? $pagesNumber : $currentPage + 1;
    $liHTML .= "<li class='page-item'><a class='page-link {$isDisabled}' href='#' page={$nextPage}'>Next</a></li>
          ";
  } else {
    $isActive = ($i == $currentPage) ? 'active' : "";
    $liHTML .= "<li class='page-item'><a class='page-link {$isActive}' href='#' page={$i}'>{$i}</a></li>";
  }
}

echo $liHTML;

