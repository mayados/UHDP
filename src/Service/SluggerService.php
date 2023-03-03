<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class SluggerService
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function slugElement($titre)
    {
        $slug = $this->slugger->slug($titre)->lower();

        return $slug;
    }

}

?>