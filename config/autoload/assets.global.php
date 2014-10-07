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
    
    // Assets
    'assets' => array(
        'css'   => array(
            'path'         => '/css',
            'stylesheets'  => array(
                'bootstrap'    => array(
                    'name'     => 'bootstrap.min.css',
                ),
                'font.awesome'    => array(
                    'name'     => 'font-awesome.min.css',
                ),
                'bootstrap-social' => array(
                    'name' => 'bootstrap-social.min.css'
                ),
                'main'         => array(
                    'name'     => 'main.min.css',
                ),
            )
        ),
        'js'    => array(
            'path'      => '/js',
            'inline'    => array(
                'jquery' => array(
                    'name' => 'jquery.min.js',
                ),
                'bootstrap' => array(
                    'name' => 'bootstrap.min.js',
                ),
                'main' => array(
                    'name' => 'main.min.js',
                ),
            ),
            'head'      => array(
                'respond' => array(
                    'name'     => 'respond.min.js',
                    'options'  => array('conditional' => 'lt IE 9')
                ),
                'html5shiv' => array(
                    'name'     => 'html5shiv.min.js',
                    'options'  => array('conditional' => 'lt IE 9')
                ),
            )
        )
    ),
    
);
