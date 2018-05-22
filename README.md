# cakephp-plugin-material
CakePHP 3 plugin providing helpers for http://daemonite.github.io/material/

# Installation

Install with composer:

```
composer require wrdx/cakephp-plugin-material
```

Load Plugin in ```bootstrap.php```:

```php
Plugin::load('Wrdx/Material');
```

Extend ```AppView``` in ```src/View/AppView.php```:

```php
namespace App\View;

use Wrdx\Material\View\MaterialView;

class AppView extends MaterialView {

}
```

Or alternatively use the trait:

```php
namespace App\View;

use Cake\View\View;

use Wrdx\Material\View\MaterialViewTrait;

class AppView extends View {

    use MaterialViewTrait;

    public function initialize() {
        parent::initialize();
        $this->initializeMaterial();
    }
}
```
