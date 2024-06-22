<?php

namespace Xanak\SEO;

class SeoManager
{
    public function generateMetaTags($title, $description, $keywords)
    {
        return "
            <meta name='title' content='{$title}'>
            <meta name='description' content='{$description}'>
            <meta name='keywords' content='{$keywords}'>
        ";
    }
}
