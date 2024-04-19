<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

function getTags(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  return [
    'tags' => array_values(
      $site
        ->find('liste-des-tags')
        ->childrenAndDrafts()
        ->map(function (\Kirby\Cms\Page $themeItem) {
          return [
            'title' => $themeItem->content()->title()->value(),
            'uuid' => $themeItem->content()->uuid()->value(),
            'uri' => $themeItem->uri(),
          ];
        })->data()
    ),

  ];
}
