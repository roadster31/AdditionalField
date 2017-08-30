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

namespace AdditionalField\Loop;

use AdditionalField\Model\CategoryAdditionalInformationQuery;
use AdditionalField\Model\ContentAdditionalInformationQuery;
use AdditionalField\Model\FolderAdditionalInformationQuery;
use AdditionalField\Model\ProductAdditionalInformationQuery;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\EnumType;
use Thelia\Type\TypeCollection;

class AdditionalFieldLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('object_id', null, true),
            new Argument(
                'source',
                new TypeCollection(
                    new EnumType(['product', 'category', 'content', 'folder'])
                ),
                null,
                true
            )
        );
    }

    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $additionalData) {
            $loopResultRow = new LoopResultRow();

            $loopResultRow
                ->set('ADDITIONAL_FIELD_1', $additionalData->getVirtualColumn('i18n_INFORMATION'))
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        switch ($this->getSource()) {
            case 'product':
                $query = ProductAdditionalInformationQuery::create();
                break;
            case 'category':
                $query = CategoryAdditionalInformationQuery::create();
                break;
            case 'content':
                $query = ContentAdditionalInformationQuery::create();
                break;
            case 'folder':
                $query = FolderAdditionalInformationQuery::create();
                break;
            default:
                throw new \InvalidArgumentException(sprintf("Unsupported source: '%s'", $this->getSource()));
        }

        /* manage translations */
        $this->configureI18nProcessing(
            $query,
            array(
                'INFORMATION'
            )
        );

        return $query->filterByObjectId($this->getObjectId());
    }
}