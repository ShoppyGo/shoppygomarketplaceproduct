<?php
/**
 * <your license here>
 */

namespace ShoppyGo\MarketplaceProduct\Form\Type;

use PrestaShopBundle\Form\Admin\Type\SwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options;
        $builder
            ->add(
                'CONFNAME',
                TextType::class,
                array('required'=>true)
            ) ;
    }
}
