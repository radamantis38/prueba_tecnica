<?php

declare(strict_types = 1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use App\Entity\Proceso;

final class ProcesoAdmin extends AbstractAdmin {

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void {
        $datagridMapper
                ->add('creacion', 'doctrine_orm_datetime_range', ['input_type' => 'timestamp', 'label' => 'Fecha de creación',])
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void {
        $listMapper
                ->add('numero', null, [
                    'label' => 'Número proceso'
                ])
                ->add('creacion', null, [
                    'label' => 'Fecha de creación',
                ])
                ->add('sede')
                ->add('presupuestodolar', 'currency', [
                    'currency' => 'USD',
                    'locale' => 'en_US',
                    'label' => 'Presupuesto',
                ])
                ->add('_action', null, [
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                    ],
                    'label' => 'Acciones',
        ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void {
        $formMapper
                ->add('numero', null, [
                    'label' => 'Número proceso',
                    'attr' => array(
                        'readonly' => true,
                    ),
                ])
                ->add('descripcion', null, [
                    'label' => 'Descripción',
                ])
                ->add('sede')
                ->add('presupuesto', MoneyType::class, array('currency' => 'COP', 'label' => 'Presupuesto', 'required' => false));

        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void {
        $showMapper
                ->add('numero', null, [
                    'label' => 'Número proceso',
                ])
                ->add('descripcion', null, [
                    'label' => 'Descripción',
                ])
                ->add('creacion', null, [
                    'label' => 'Fecha de creación',
                ])
                ->add('sede')
                ->add('presupuestodolar', 'currency', [
                    'currency' => 'USD',
                    'locale' => 'en_US',
                    'label' => 'Presupuesto',
                ])
        ;
    }

    public function getNewInstance() {
        $instance = parent::getNewInstance();
        $numero = '00000001';
        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('p')
                ->from('App\Entity\Proceso', 'p')
                ->orderBy('p.id', 'DESC')
                ->setMaxResults( 1 );
               $query = $qb->getQuery();

        $ultimo_proceso = $query->execute();
        if (isset($ultimo_proceso[0])) {
            $last_cons = ((int) $ultimo_proceso[0]->getNumero()) + 1;
            $numero = str_pad(strval($last_cons), 8, "0", STR_PAD_LEFT);
        }
        $instance->setNumero($numero);
        return $instance;
    }

}
