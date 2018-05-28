<?php

namespace Material\View;

use Cake\View\View;

/**
 * Class MaterialView
 *
 * @package Material\View
 *
 * @property \Material\View\Helper\FormHelper $Form
 * @property \Material\View\Helper\HtmlHelper $Html
 */
class MaterialView extends View {

    use MaterialViewTrait;

    public function initialize() {
        parent::initialize();

        $this->initializeMaterial();
    }
}