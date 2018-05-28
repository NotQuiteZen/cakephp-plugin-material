<?php

namespace Material\View;

/**
 * Trait MaterialViewTrait
 *
 * @package Material\View
 */
trait MaterialViewTrait {

    public function initializeMaterial() {

        # Load HtmlHelper
        $this->loadHelper('Html', ['className' => 'Material.Html']);

        # Load FormHelper
        $this->loadHelper('Form', ['className' => 'Material.Form']);

        # Load SnackbarHelper
        $this->loadHelper('Snackbar', ['className' => 'Material.Snackbar']);

    }

}