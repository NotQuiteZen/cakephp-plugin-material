<?php

namespace Wrdx\Material\View;

use Cake\View\View;

/**
 * Class MaterialView
 *
 * @package Wrdx\Material\View
 *
 * @property \Wrdx\Material\View\Helper\FormHelper $Form
 * @property \Wrdx\Material\View\Helper\HtmlHelper $Html
 */
class MaterialView extends View {

    use MaterialViewTrait;

    public function initialize() {
        parent::initialize();

        $this->initializeMaterial();
    }
}