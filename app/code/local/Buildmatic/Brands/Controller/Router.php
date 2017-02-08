<?php 
class Buildmatic_Brands_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract 
{
    public function initControllerRouters($observer) 
    {
        $front = $observer->getEvent()->getFront();
        $front->addRouter('buildmatic_brands', $this);
        return $this;
    }

    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::isInstalled()) 
        {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }

        $urlKey = trim($request->getPathInfo(), '/');
        $check = array(); //you can add here multiple entities
        $check['buildmatic_brands/brands'] = new Varien_Object(array(
            //'prefix'        => Mage::getStoreConfig('brands_section/brands_Settings/url_prefix'),
            'model'         =>'buildmatic_brands/brands',
            'controller'    => 'brands',
            'action'        => 'view',
            'param'         => 'id',
        ));
        foreach ($check as $key=>$settings) {
            /*if ($settings['prefix']){
                $parts = explode('/', $urlKey);
                if ($parts[0] != $settings['prefix'] || count($parts) != 2){
                    continue;
                }
                $urlKey = $parts[1];
            }*/
            //$model = Mage::getModel($settings->getModel());
            $model = Mage::getModel('buildmatic_brands/brands');
            $checkid = $model->getCollection()->addFieldToFilter('url_key',$urlKey)->addFieldToSelect('id');
            $id = $checkid->getData();
            if ($id){
                if ($settings->getCheckPath() && !$model->load($id)->getStatusPath()) {
                    continue;
                }
                $request->setModuleName('brands')
                    ->setControllerName($settings->getController())
                    ->setActionName($settings->getAction())
                    ->setParam($settings->getParam(), $id);
                $request->setAlias(
                    Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                    $urlKey
                );
                return true;
            }
        }
        return false;
    }
}