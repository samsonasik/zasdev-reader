<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

namespace ZasDev\Application\Controller;

use ZasDev\RSS\Event\FeedEvent;
use ZasDev\RSS\Service\FeedService;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var FeedService $feedService */
        $feedService = $this->getServiceLocator()->get('ZasDev\RSS\Service\FeedService');
        Debug::dump(count($feedService->getEventManager()->getListeners(FeedEvent::EVENT_FEED_SAVED)));
        return new ViewModel();
    }
}
