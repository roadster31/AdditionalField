<?php
/*************************************************************************************/
/*                                                                                   */
/*      This file is not free software                                               */
/*                                                                                   */
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 20/12/2015 20:25
 */

namespace AdditionalField\EventListeners;

use AdditionalField\AdditionalField;
use AdditionalField\Model\CategoryAdditionalInformation;
use AdditionalField\Model\CategoryAdditionalInformationQuery;
use AdditionalField\Model\ContentAdditionalInformation;
use AdditionalField\Model\ContentAdditionalInformationQuery;
use AdditionalField\Model\FolderAdditionalInformation;
use AdditionalField\Model\FolderAdditionalInformationQuery;
use AdditionalField\Model\ProductAdditionalInformation;
use AdditionalField\Model\ProductAdditionalInformationQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\ActionEvent;
use Thelia\Core\Event\Category\CategoryEvent;
use Thelia\Core\Event\Content\ContentEvent;
use Thelia\Core\Event\Folder\FolderEvent;
use Thelia\Core\Event\Product\ProductEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\TheliaFormEvent;
use Thelia\Core\Translation\Translator;

class ListenerManager implements EventSubscriberInterface
{
    public function addFieldToForm(TheliaFormEvent $event)
    {
        $event->getForm()->getFormBuilder()->add(
            'additional_field_1',
            'text',
            [
                'required' => false,
                'label' => Translator::getInstance()->trans(
                    'Information complémentaire',
                    [],
                    AdditionalField::DOMAIN_NAME
                ),
                'label_attr'  => [
                    'help' => Translator::getInstance()->trans("Vous pouvez indiquer ici une information complémentaire de votre choix.")
                ]
            ]
        );
    }

    public function processObjectFields(ActionEvent $event, ModelCriteria $queryClass, $object, $objectId)
    {
        // Utilise le principe NON DOCUMENTE qui dit que si une form bindée à un event trouve
        // un champ absent de l'event, elle le rend accessible à travers une méthode magique.
        // (cf. ActionEvent::bindForm())
        $additionalFieldValue = $event->additional_field_1;

        $additionalField = $queryClass->findOneByObjectId($objectId);

        if ($additionalFieldValue) {
            if (null === $additionalField) {
                $object
                    ->setObjectId($objectId)
                    ->setLocale($event->getLocale())
                    ->setInformation($additionalFieldValue)
                    ->save()
                ;
            } else {
                $additionalField
                    ->setLocale($event->getLocale())
                    ->setInformation($additionalFieldValue)
                    ->save()
                    ;
            }
        } elseif (null !== $additionalField) {
            try {
                $additionalField
                    ->removeTranslation($event->getLocale());

            } catch (\Exception $ex) {
                /* To catch a propel problem (the i18n table is updated)

                Warning: Invalid argument supplied for foreach()

                in ContentAdditionalInformation.php line 1472
                at ErrorHandler->handleError('2', 'Invalid argument supplied for foreach()', '/home/pfk/www/local/modules/AdditionalField/Model/Base/ContentAdditionalInformation.php', '1472', array('locale' => 'en_US', 'con' => null, 'this' => object(ContentAdditionalInformation))) in ContentAdditionalInformation.php line 1472
                */
            }
        }
    }

    public function processProductFields(ProductEvent $event)
    {
        if ($event->hasProduct()) {
            $this->processObjectFields($event, ProductAdditionalInformationQuery::create(), new ProductAdditionalInformation(), $event->getProduct()->getId());
        }
    }

    public function processCategoryFields(CategoryEvent $event)
    {
        if ($event->hasCategory()) {
            $this->processObjectFields($event, CategoryAdditionalInformationQuery::create(), new CategoryAdditionalInformation(), $event->getCategory()->getId());
        }
    }

    public function processFolderFields(FolderEvent $event)
    {
        if ($event->hasFolder()) {
            $this->processObjectFields($event, FolderAdditionalInformationQuery::create(), new FolderAdditionalInformation(), $event->getFolder()->getId());
        }
    }

    public function processContentFields(ContentEvent $event)
    {
        if ($event->hasContent()) {
            $this->processObjectFields($event, ContentAdditionalInformationQuery::create(), new ContentAdditionalInformation(), $event->getContent()->getId());
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_creation" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_product_modification" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_content_creation" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_content_modification" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_category_creation" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_category_modification" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_folder_creation" => ['addFieldToForm', 128],
            TheliaEvents::FORM_BEFORE_BUILD . ".thelia_folder_modification" => ['addFieldToForm', 128],

            TheliaEvents::PRODUCT_UPDATE  => ['processProductFields', 100],
            TheliaEvents::PRODUCT_CREATE  => ['processProductFields', 100],

            TheliaEvents::CATEGORY_CREATE  => ['processCategoryFields', 100],
            TheliaEvents::CATEGORY_UPDATE  => ['processCategoryFields', 100],

            TheliaEvents::FOLDER_CREATE  => ['processFolderFields', 100],
            TheliaEvents::FOLDER_UPDATE  => ['processFolderFields', 100],

            TheliaEvents::CONTENT_CREATE  => ['processContentFields', 100],
            TheliaEvents::CONTENT_UPDATE  => ['processContentFields', 100],
        ];
    }

}
