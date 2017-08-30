<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 *
 * Creation date: 23/03/2015 12:09
 */

namespace AdditionalField\Hook;

use AdditionalField\Model\CategoryAdditionalInformationQuery;
use AdditionalField\Model\ContentAdditionalInformationQuery;
use AdditionalField\Model\FolderAdditionalInformationQuery;
use AdditionalField\Model\ProductAdditionalInformationQuery;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class HookManager extends BaseHook
{
    /**
     * @param HookRenderEvent $event
     * @param ActiveRecordInterface $fieldValue
     */
    private function processFieldHook(HookRenderEvent $event, $fieldValue)
    {
        $locale = $this->getSession()->getAdminEditionLang()->getLocale();

        $event->add(
            $this->render(
                "object-additional-fields.html",
                [
                    'additional_field_1_value' => $fieldValue ? $fieldValue->setLocale($locale)->getInformation() : '',
                    'form' => $event->getArgument('form')
                ]
            )
        );
    }

    public function onProductEditRightColumnBottom(HookRenderEvent $event)
    {
        $this->processFieldHook(
            $event,
            ProductAdditionalInformationQuery::create()->findOneByObjectId($event->getArgument('product_id'))
        );
    }

    public function onCategoryEditRightColumnBottom(HookRenderEvent $event)
    {
        $this->processFieldHook(
            $event,
            CategoryAdditionalInformationQuery::create()->findOneByObjectId($event->getArgument('category_id'))
        );
    }

    public function onContentEditRightColumnBottom(HookRenderEvent $event)
    {
        $this->processFieldHook(
            $event,
            ContentAdditionalInformationQuery::create()->findOneByObjectId($event->getArgument('content_id'))
        );
    }

    public function onFolderEditRightColumnBottom(HookRenderEvent $event)
    {
        $this->processFieldHook(
            $event,
            FolderAdditionalInformationQuery::create()->findOneByObjectId($event->getArgument('folder_id'))
        );
    }
}
