<?php
/**
* <your license here>
*/

namespace ShoppyGo\MarketplaceProduct\Controller;

use ShoppyGo\MarketplaceProduct\Form\Type\ConfigurationType;
use Configuration;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class ConfigurationController extends FrameworkBundleAdminController
{
	public function configuration(Request $request)
	{
        $conf = [
            'CONFNAME',
        ];
        $data = [];
        foreach ($conf as $key) {
            $data[$key] = Configuration::get(
                $key,
                $this->getContext()->shop->id_shop_group,
                $this->getContext()->shop->id
            );
        }
        $form = $this->createForm(ConfigurationType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
            foreach ($data as $conf_name => $conf_value) {
                Configuration::updateValue(
                    $conf_name,
                    $conf_value,
                    $this->getContext()->shop->id_shop_group,
                    $this->getContext()->shop->id
                );
            }
        $this->addFlash('success', 'Configuration saved');
        }
        return $this->render(
            '@Modules/shoppygomarketplaceproduct/views/templates/admin/controller/admin_configuration.html.twig',
            array(
                'form' => $form->createView(),
                )
            );

	}
}
