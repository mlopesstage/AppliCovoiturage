<?php

namespace App\Form;

use App\Entity\Path;
use App\Entity\Place;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\GreaterThan;

class PathType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateTime',DateTimeType::class, [
            	'constraints' => new GreaterThan(new \DateTime('Europe/Paris')), 'label_format' => 'comment.date', 'years' => range(2020,2030)])
            ->add('seats',IntegerType::class, [
                'constraints'=> [new Range(['min'=> 1, 'max'=>5]),], 'label_format' => 'covoit.nbplace'])
            ->add('price',MoneyType::class, [
                'constraints'=> [new Range(['min'=> 1, 'max'=>100]),], 'label_format' => 'covoit.price'])
            ->add('departure',EntityType::class, [
                'class'=>Place::class,'choice_label' => 'name','label_format' => 'covoit.start'])
            ->add('destination',EntityType::class, [
                'class'=>Place::class,'choice_label' => 'name', 'label_format' => 'covoit.end'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Path::class,
        ]);
    }
}