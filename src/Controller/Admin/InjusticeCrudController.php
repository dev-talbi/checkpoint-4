<?php

namespace App\Controller\Admin;

use App\Entity\Injustice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InjusticeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Injustice::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
