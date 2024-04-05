<?php

namespace App\Controller\Admin\Crud;

use App\Entity\FamilyAnimals;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FamilyAnimalsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FamilyAnimals::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name', "Nom de familles d'animaux"),
            TextEditorField::new('description', "Description"),
        ];
    }
}
