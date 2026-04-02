<?php

function getAbout(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $contactPage = $site->find('a-propos');

  if( $contactPage == null ) return [
    'error' => '"a-propos" does\'nt exist',
    'data' => null,
  ];

  return [
    'error' => null,
    'data' => [
      'listOfDetails_about' => $contactPage->listOfDetails_about()->toStructure()->map(function ($value) {
        return [
          'name' => $value->name()->value(),
          'value' => $value->value()->value(),
        ];
      })->data(),
      'textabout' => $contactPage->textabout()->value(),
      'mapImage_about' => $contactPage->mapImage_about()->toFile() ? getJsonEncodeImageData($contactPage->mapImage()->toFile()) : null,
    ],
  ];
}
