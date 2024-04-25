<?php

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getProjectByUID(string $pageUid, Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $project = $site->find('projets')->children()->find($pageUid);


  if ($project == null) {
    return [
      'error' => 'la page n\'existe pas',
    ];
  } else {
    return [

      'imageCover'        =>   array_values(getImageArrayDataInPage($project->imageCover())),
//      galleryProject      =>   (IApiImageOfProject | IApiVideo)[]
      'htmlContent'       =>  $project->htmlContent()->value(),
      'listOfDetails'     =>  $project->listOfDetails()->toStructure()->map(function ($value) {
        return [
          'name' => $value->name()->value(),
          'value' => $value->value()->value(),
        ];
      })->data(),


//      same as get.$project
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
  }
}
