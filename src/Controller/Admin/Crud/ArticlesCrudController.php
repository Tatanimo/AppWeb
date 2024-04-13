<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            TextEditorField::new('content', 'Contenu'),
            DateField::new('publication_date', 'Date publication'),
            DateField::new('modification_date', 'Date modification'),
            ArrayField::new('keyword', 'Mots clés'),
            TextField::new('slug', 'Slug'),
            BooleanField::new('state', 'Visible'),
        ];
    }
}
