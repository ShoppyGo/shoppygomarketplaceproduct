<?php
/**
 * Copyright since 2022 Bwlab of Luigi Massa and Contributors
 * Bwlab of Luigi Massa is an Italy Company
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@shoppygo.io so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade ShoppyGo to newer
 * versions in the future. If you wish to customize ShoppyGo for your
 * needs please refer to https://docs.shoppygo.io/ for more information.
 *
 * @author    Bwlab and Contributors <contact@shoppygo.io>
 * @copyright Since 2022 Bwlab of Luigi Massa and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_.'shoppygomarketplaceproduct'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.
    'autoload.php';

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

/**
 * Implement {widget name="shoppygomarketplaceproduct" hook='displaySellerProductDetail' id_product=$product.id}
 */
class Shoppygomarketplaceproduct extends Module implements WidgetInterface
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'shoppygomarketplaceproduct';
        $this->version = '1.0.0';

        $this->author = 'ShoppyGo';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Display seller name', [], 'Modules.Shoppygomarketplaceproduct.Admin');
        $this->description =
            $this->trans('Widget to display names of sellers', [], 'Modules.Shoppygomarketplaceproduct.Admin');
        $this->confirmUninstall = $this->trans('Are you sure?', [], 'Modules.Shoppygomarketplaceproduct.Admin');

        $this->ps_versions_compliancy = array('min' => '8.0.0', 'max' => _PS_VERSION_);
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink(
                'AdminShoppygomarketplaceproduct', true, ['route' => 'admin_shoppygomarketplaceproduct_configuration']
            )
        );
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        $id_product = $configuration['id_product'];
        $mkt = new \MarketplaceCoreFront($this->get('doctrine'), $this->context);
        $seller_ids = $mkt->findSellerByProduct($id_product);
        $sellers = array();
        foreach ($seller_ids as $seller_id) {
            $sellers[] = [
                'seller' => new \Supplier($seller_id),
                'seller_page' => $this->context->link->getSupplierLink(
                    $seller_id
                ),
            ];
        }

        return $sellers;
    }

    public function install()
    {
        return parent::install();
    }

    public function renderWidget($hookName, array $configuration)
    {
        $key = $this->name.'|'.$hookName;

        $sellers = $this->getWidgetVariables($hookName, $configuration);

        if ('displaySellerProductDetail' === $hookName) {
            if ($this->context->controller->php_self === 'supplier') {
                return;
            }
            $template = 'module:shoppygomarketplaceproduct/views/templates/hook/sellers.tpl';

            if (!$this->isCached($template, $this->getCacheId($key))) {
                $this->smarty->assign(['sellers' => $sellers]);
            }

            return $this->fetch($template, $this->getCacheId($key));
        }
    }

    public function uninstall()
    {
        return parent::uninstall();
    }
}
