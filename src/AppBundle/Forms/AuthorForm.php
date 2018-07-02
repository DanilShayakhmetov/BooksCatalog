<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 02.07.18
 * Time: 21:46
 */

namespace AppBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\AuthorTab;


class AuthorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('LastName', TextareaType::class)
            ->add('Firstname', TextareaType::class)
            ->add('MiddleName',TextareaType::class)
            ->add('');
    }

}