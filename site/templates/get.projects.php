<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

echo json_encode([
  'projects' => array_values($site
    ->find('projets')
    ->children()
    ->filterBy('status', 'listed')
    ->map(function (\Kirby\Cms\Page $project) use ($kirby, $site) {
      return [
        'status'                => $project->status(),
        'uid'                   => $project->uid(),
        'slug'                  => $project->slug(),
        'title'                 => $project->title()->value(),
        'arrayOfImagesCarousel' => array_values(getImageArrayDataInPage($project->arrayOfImagesCarousel())),
        'imageCoverForIndex'    => getJsonEncodeImageData($project->imageCoverForIndex()->toFile()),
        'selfInitiated'         => $project->selfInitiated()->value() == 'true',
        'date'                  => $project->date()->value(),
        'tags'                  => array_map(function (string $themeSlug) use ($kirby) {
          $themePage = $kirby->page(trim($themeSlug));
          if ($themePage == null) return null;
          return [
            'title' => $themePage->title()->value(),
            'uid'   => $themePage->uid(),
            'uuid'  => $themePage->content()->uuid()->value(),
            'uri'   => $themePage->uri(),
          ];
        }, explode(',', $project->tags()->value())),
      ];
    })->data()
  )
]);
