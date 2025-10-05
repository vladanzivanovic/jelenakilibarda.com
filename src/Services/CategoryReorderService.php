<?php

declare(strict_types=1);

namespace App\Services;


use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Repository\CategoryRepository;

final class CategoryReorderService
{
    private CategoryRepository $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function reorderPosition(Category $category, array $positions): void
    {
        foreach ($positions as $position) {
            $relatedCategory = $this->categoryRepository->getBySlug($position['slug']);

            if (null === $relatedCategory) {
                $category->setPosition($position['position']);

                continue;
            }

            $relatedCategory->setPosition($position['position']);
        }
    }

    public function reorderPositionsOnDelete(Category $deletedCategory): void
    {
        $categories = $this->categoryRepository->getCategoriesByParentOrderedByPosition(
            $deletedCategory->getParent(),
            $deletedCategory
        );


        foreach ($categories as $index => $category) {
            $category->setPosition($index+1);
        }
    }
}
