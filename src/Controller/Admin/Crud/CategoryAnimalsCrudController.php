<?php

namespace App\Controller\Admin\Crud;

use App\Entity\CategoryAnimals;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryAnimalsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryAnimals::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID'),
            TextField::new('name', 'Nom de catégorie'),
            TextEditorField::new('description', 'Description'),
            AssociationField::new('fk_family', "Familles d'animaux")->autocomplete()->formatValue(
                function ($value, $entity) {
                    return $value != null ? $value->getName() : $entity->getName();
                }
            ),
        ];
    }
}
