<?php
namespace TypiCMS\Modules\News\Controllers;

use TypiCMS\Modules\News\Repositories\NewsInterface;
use TypiCMS\Modules\News\Services\Form\NewsForm;
use TypiCMS\Controllers\AdminSimpleController;

class AdminController extends AdminSimpleController
{

    public function __construct(NewsInterface $news, NewsForm $newsform)
    {
        parent::__construct($news, $newsform);
        $this->title['parent'] = trans_choice('news::global.news', 2);
    }
}
