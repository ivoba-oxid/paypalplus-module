<?php
/**
 * This file is part of OXID eSales PayPal Plus module.
 *
 * OXID eSales PayPal Plus module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales PayPal Plus module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales PayPal Plus module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2015
 */

/**
 * Class paypPayPalPlusOxAddressTest
 * Tests for paypPayPalPlusOxAddress model.
 *
 * @see paypPayPalPlusOxAddress
 */
class paypPayPalPlusOxAddressTest extends OxidTestCase
{

    /**
     * Subject under the test.
     *
     * @var paypPayPalPlusOxAddress|PHPUnit_Framework_MockObject_MockObject
     */
    protected $SUT;


    /**
     * @inheritDoc
     *
     * Set SUT state before test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->SUT = $this->getMock('paypPayPalPlusOxAddress', array('_paypPayPalPlusOxAddress_save_parent'));
    }


    /**
     * test `save` parent function returns false, no actions are made and the function returns false
     */
    public function testSave_parentNotSaved_returnFalse()
    {
        $oProfile = $this->getMock('paypPayPalPlusProfile', array('__call', 'postSave'));
        $oProfile->expects($this->never())->method('postSave');
        oxTestModules::addModuleObject('paypPayPalPlusProfile', $oProfile);

        $this->SUT->expects($this->once())->method('_paypPayPalPlusOxAddress_save_parent')->will(
            $this->returnValue(false)
        );

        $this->assertFalse($this->SUT->save());
    }

    /**
     * test `save`, parent function saves address and returns id, post save hook is initiated,
     * returning the same value as parent
     */
    public function testSave_parentSaved_returnTrue()
    {
        $sTestId = 'someTestId';

        $oProfile = $this->getMock('paypPayPalPlusProfile', array('__call', 'postSave'));
        $oProfile->expects($this->once())->method('postSave')->with($this->SUT);
        oxTestModules::addModuleObject('paypPayPalPlusProfile', $oProfile);

        $this->SUT->expects($this->once())->method('_paypPayPalPlusOxAddress_save_parent')->will(
            $this->returnValue($sTestId)
        );

        $this->assertSame($sTestId, $this->SUT->save());
    }
}
