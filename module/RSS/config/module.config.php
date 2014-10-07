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

return array(

    'controllers' => array(
        'factories' => array(
            'RSS\Controller\Feed' => 'RSS\Controller\FeedControllerFactory'
        )
    ),

    'console' => array(
        'router' => array(
            'routes' => array(

                'refresh-feeds' => array(
                    'options' => array(
                        'route' => 'zdr feeds --refresh [-v|--verbose]',
                        'defaults' => array(
                            'controller' => 'RSS\Controller\Feed',
                            'action' => 'refresh'
                        )
                    )
                )

            ),
        ),
    ),

    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

);
