<?php

namespace NotQuiteZen\Material\View;

/**
 * Trait MaterialViewTrait
 *
 * @package NotQuiteZen\Material\View
 */
trait MaterialViewTrait {

    public function initializeMaterial() {

        # Load HtmlHelper
        $this->loadHelper('Html', ['className' => 'NotQuiteZen/Material.Html']);

        # Load FormHelper
        $this->loadHelper('Form', ['className' => 'NotQuiteZen/Material.Form']);

    }

}