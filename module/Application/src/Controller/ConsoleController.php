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

namespace Application\Controller;

use Application\Util\AppData;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * Class ConsoleController
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class ConsoleController extends AbstractConsoleController
{
    /**
     * @var AdapterInterface
     */
    protected $console;

    public function __construct(AdapterInterface $console)
    {
        $this->console = $console;
    }

    public function versionAction()
    {
        $this->console->write(AppData::APP_VERSION . PHP_EOL, ColorInterface::LIGHT_GREEN);
    }
}
