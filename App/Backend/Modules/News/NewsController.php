<?php
namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\News;

class NewsController extends BackController
{
  // ...
  
  public function executeInsert(HTTPRequest $request)
  {
    if ($request->postExists('auteur'))
    {
      $this->processForm($request);
    }
    
    $this->page->addVar('title', 'Ajout d\'une news');
  }
  
  public function processForm(HTTPRequest $request)
  {
    $news = new News([
      'auteur' => $request->postData('auteur'),
      'titre' => $request->postData('titre'),
      'contenu' => $request->postData('contenu')
    ]);
    
    // L'identifiant de la news est transmis si on veut la modifier.
    if ($request->postExists('id'))
    {
      $news->setId($request->postData('id'));
    }
    
    if ($news->isValid())
    {
      $this->managers->getManagerOf('News')->save($news);
      
      $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
    }
    else
    {
      $this->page->addVar('erreurs', $news->erreurs());
    }
    
    $this->page->addVar('news', $news);
  }
}