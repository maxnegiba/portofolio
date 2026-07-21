<?php

namespace App\Support\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class CustomPolicy implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::CONNECT, [Keyword::SELF, 'https://stats.posesoart.ro'])
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::IMG, [Keyword::SELF, 'data:', 'https:'])
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::FONT, [Keyword::SELF, 'data:', 'https://cdnjs.cloudflare.com', 'https://fonts.gstatic.com', 'https://fonts.googleapis.com'])
            ->add(Directive::STYLE, [Keyword::SELF, 'https://cdnjs.cloudflare.com', Keyword::UNSAFE_INLINE])
            ->add(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_EVAL, 'https://stats.posesoart.ro'])
            ->addNonce(Directive::SCRIPT);
    }
}
