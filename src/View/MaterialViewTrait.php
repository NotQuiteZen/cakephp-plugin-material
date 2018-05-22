<?php

namespace Wrdx\Material\View;

/**
 * Trait MaterialViewTrait
 *
 * @package Wrdx\Material\View
 */
trait MaterialViewTrait {

    public function initializeMaterial() {

        # Load HtmlHelper
        $this->loadHelper('Html', ['className' => 'Wrdx/Material.Html']);

        # Load FormHelper
        $this->loadHelper('Form', ['className' => 'Wrdx/Material.Form']);

    }

}