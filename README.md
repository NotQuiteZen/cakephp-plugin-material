# cakephp-plugin-material
CakePHP 3 plugin providing helpers for http://daemonite.github.io/material/

# Installation

Install with composer:

```
composer require notquitezen/cakephp-plugin-material
```

Load Plugin in ```bootstrap.php```:

```php
Plugin::load('NotQuiteZen/Material');
```

Load the Snackbar component in ```src/Controller/AppController.php```

```
public function initialize() {
    parent::initialize();
    $this->loadComponent('Material.Snackbar');
}
```

Extend ```AppView``` in ```src/View/AppView.php```:

```php
namespace App\View;

use Material\View\MaterialView;

class AppView extends MaterialView {

}
```

Or alternatively use the trait:

```php
namespace App\View;

use Cake\View\View;

use Material\View\MaterialViewTrait;

class AppView extends View {

    use MaterialViewTrait;

    public function initialize() {
        parent::initialize();
        $this->initializeMaterial();
    }
}
```
