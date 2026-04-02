<?php

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getContact(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $contactPage = $site->find('a-propos');

  if( $contactPage == null ) return [
    'error' => '"a-propos" does\'nt exist',
    'data' => null,
  ];

  return [
    'error' => null,
    'data' => [
      'listOfDetails_contact' => $contactPage->listOfDetails_contact()->toStructure()->map(function ($value) {
        return [
          'name' => $value->name()->value(),
          'value' => $value->value()->value(),
        ];
      })->data(),
      'textcontact' => $contactPage->textcontact()->value(),
      'mapImage' => $contactPage->mapImage()->toFile() ? getJsonEncodeImageData($contactPage->mapImage()->toFile()) : null,
    ],
  ];
}
