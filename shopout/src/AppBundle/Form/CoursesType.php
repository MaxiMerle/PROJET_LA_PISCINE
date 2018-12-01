<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CoursesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('ville', EntityType::class,['class' => 'AppBundle:Villes','choice_label'=>'nom'])
            ->add('prix', IntegerType::class,array('attr' => ['placeholder' => 'Exemple 3€...']))
            ->add('adresseDepart',TextType::class, array('attr' => ['placeholder' => 'Exemple 21 rue moliere...']))
            ->add('adresseArrivee',TextType::class, array('attr' => ['placeholder' => 'Exemple 21 rue moliere...']))

            ->add('dateLivraison', DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd',))
            ->add('description',TextareaType::class, array('attr' => ['row' => '3', 'placeholder' => 'Quels objets souhaitez-vous ?']))
            ->add('save', SubmitType::class, array('label' => 'Ajouter une course'));
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Courses'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_courses';
    }


}
