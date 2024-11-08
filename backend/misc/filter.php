<?php

$relationships = [
  [
    "name" => "Tami",
    "relationship" => "love",
  ],
  [
    "name" => "Margó",
    "relationship" => "friend",
  ],
  [
    "name" => "Ildi",
    "relationship" => "sexual",
  ],
  [
    "name" => "Erika",
    "relationship" => "sexual",
  ],
];

$filteredItems = array_filter($relationships, function ($item, $relationshipType = "friend") {
    return $item["relationship"] != $relationshipType;
  });


print_r($filteredItems);
