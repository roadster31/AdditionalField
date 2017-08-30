<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace AdditionalField;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class AdditionalField extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'additionalfield';

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con->getWrappedConnection());

        $database->insertSql(null, array(__DIR__."/Config/thelia.sql"));
    }

    public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
    {
        if ($deleteModuleData) {
            $database = new Database($con->getWrappedConnection());

            $database->insertSql(null, array(__DIR__."/Config/drop.sql"));
        }
    }

}
