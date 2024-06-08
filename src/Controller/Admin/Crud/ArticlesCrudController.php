<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Articles;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $slugger = new AsciiSlugger();
        $TEMP = "Un titre temporaire pour test";

        return [
            TextField::new('title', 'Titre')
                ->setMaxLength(50),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title'),
            ImageField::new('image', 'Image')
                ->setBasePath("public/img/articles")
                ->setUploadDir("public/img/articles")
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[slug].[extension]'),
            TextField::new('description', 'Description')
                ->setMaxLength(255),
            TextEditorField::new('content', 'Contenu'),
            DateTimeField::new('publication_date', 'Date publication')
                ->setFormTypeOptions([
                    'data' => new DateTime(),
                ]),
            ArrayField::new('keyword', 'Mots clés'),
            BooleanField::new('state', 'Mettre en ligne'),
        ];
    }
}
