<?php

namespace NotQuiteZen\Material\View;

use Cake\View\View;

/**
 * Class MaterialView
 *
 * @package NotQuiteZen\Material\View
 *
 * @property \NotQuiteZen\Material\View\Helper\FormHelper $Form
 * @property \NotQuiteZen\Material\View\Helper\HtmlHelper $Html
 */
class MaterialView extends View {

    use MaterialViewTrait;

    public function initialize() {
        parent::initialize();

        $this->initializeMaterial();
    }
}