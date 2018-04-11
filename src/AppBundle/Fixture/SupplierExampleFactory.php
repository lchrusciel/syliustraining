<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Supplier;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SupplierExampleFactory extends AbstractExampleFactory
{
    /** @var OptionsResolver */
    private $resolver;

    /** @var FactoryInterface */
    private $factory;

    /** @var \Faker\Generator */
    private $faker;

    public function __construct(FactoryInterface $factory)
    {
        $this->resolver = new OptionsResolver();
        $this->factory = $factory;
        $this->faker = \Faker\Factory::create();

        $this->configureOptions($this->resolver);
    }

    public function create(array $options = []): Supplier
    {
        $option = $this->resolver->resolve($options);

        /** @var Supplier $supplier */
        $supplier = $this->factory->createNew();

        $supplier->setName($option['name']);
        $supplier->setCode($option['code']);

        return $supplier;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('name', function (Options $option) {
                return $this->faker->words(3, true);
            })
            ->setDefault('code', function (Options $option) {
                return StringInflector::nameToCode($option['name']);
            })
        ;
    }
}
