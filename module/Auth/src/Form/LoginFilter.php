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

namespace Auth\Form;

use Zend\InputFilter\InputFilter;

/**
 * Filters for login form
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $this->initFilters();
    }
    
    /**
     * Initializes filters for each element in LoginForm
     * @see \Application\Form\LoginForm
     */
    protected function initFilters()
    {
        // Username
        $this->add(array(
            'name'      => LoginForm::USER,
            'required'  => true
        ));
        
        // Password
        $this->add(array(
            'name'      => LoginForm::PASSWORD,
            'required'  => true
        ));
    }
}
