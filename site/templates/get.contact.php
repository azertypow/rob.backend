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
      'textcontact' => $contactPage->textcontact()->value(),
      'mapImage' => $contactPage->mapImage() ? getJsonEncodeImageData($contactPage->mapImage()->toFile()) : null,
    ],
  ];
}
