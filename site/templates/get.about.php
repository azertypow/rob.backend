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
      'textabout' => $contactPage->textabout()->value(),
    ],
  ];
}
