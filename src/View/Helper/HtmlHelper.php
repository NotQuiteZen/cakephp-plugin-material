<?php

namespace Material\View\Helper;

use Cake\View\View;
use Cake\Utility\Hash;

/**
 * Class HtmlHelper
 *
 * Html helper for http://daemonite.github.io/material/
 *
 * @package App\View\Helper
 *
 * @method  h1(string $text, array $options)
 * @method  h2(string $text, array $options)
 * @method  h3(string $text, array $options)
 * @method  h4(string $text, array $options)
 * @method  h5(string $text, array $options)
 * @method  image(string $text, array $options)
 *
 */
class HtmlHelper extends \Cake\View\Helper\HtmlHelper {

    private $bootstrapTemplates = [
        'breadCrumbOl' => '<ol{{attrs}}>{{content}}</ol>',
        'breadCrumbLi' => '<li{{attrs}}>{{content}}</li>',
        'h1' => '<h1{{attrs}}>{{content}}</h1>',
        'h2' => '<h2{{attrs}}>{{content}}</h2>',
        'h3' => '<h3{{attrs}}>{{content}}</h3>',
        'h4' => '<h4{{attrs}}>{{content}}</h4>',
        'h5' => '<h5{{attrs}}>{{content}}</h5>',
        'h6' => '<h6{{attrs}}>{{content}}</h6>',
    ];

    public function __construct(View $View, array $config = []) {
        $this->_defaultConfig['templates'] = array_merge($this->_defaultConfig['templates'], $this->bootstrapTemplates);

        parent::__construct($View, $config);
    }

    public function __call($method, $params) {
        $text = Hash::get($params, 0);
        $options = Hash::get($params, 1);

        return $this->formatTemplate($method, [
            'attrs' => $this->templater()->formatAttributes($options),
            'content' => $text,
        ]);
    }

    /**
     * Returns breadcrumbs as a (x)html list formatted for Bootstrap
     *
     * This method uses HtmlHelper::tag() to generate list and its elements. Works
     * similar to HtmlHelper::getCrumbs(), so it uses options which every
     * crumb was added with.
     *
     * ### Options
     *
     * - `separator` Separator content to insert in between breadcrumbs, defaults to ''
     * - `firstClass` Class for wrapper tag on the first breadcrumb, defaults to 'first'
     * - `lastClass` Class for wrapper tag on current active page, defaults to 'last'
     * - `itemClass` Class for item tag set to false for none
     *
     * @param array             $options   Array of HTML attributes to apply to the generated list elements.
     * @param string|array|bool $startText This will be the first crumb, if false it defaults to first crumb in array.
     *                                     Can also be an array, see `HtmlHelper::getCrumbs` for details.
     *
     * @return string|null Breadcrumbs HTML list.
     * @link       http://book.cakephp.org/3.0/en/views/helpers/html.html#creating-breadcrumb-trails-with-htmlhelper
     * @deprecated 3.3.6 Use the BreadcrumbsHelper instead
     */
    public function getCrumbList(array $options = [], $startText = false) {
        $defaults = [
            'firstClass' => 'first',
            'lastClass' => 'last',
            'separator' => '',
            'escape' => true,
            'class' => 'breadcrumb',
            'itemClass' => 'breadcrumb-item',
        ];

        $options += $defaults;
        $firstClass = $options['firstClass'];
        $lastClass = $options['lastClass'];
        $separator = $options['separator'];
        $escape = $options['escape'];
        $itemClass = $options['itemClass'];
        unset($options['firstClass'], $options['lastClass'], $options['separator'], $options['escape'], $options['itemClass']);

        $crumbs = $this->_prepareCrumbs($startText, $escape);
        if (empty($crumbs)) {
            return null;
        }

        $result = '';
        $crumbCount = count($crumbs);
        $ulOptions = $options;
        foreach ($crumbs as $which => $crumb) {
            $options = [];
            if (empty($crumb[1])) {
                $elementContent = $crumb[0];
            } else {
                $elementContent = $this->link($crumb[0], $crumb[1], $crumb[2]);
            }

            if ($itemClass !== false) {
                if (is_array($itemClass)) {
                    $liClass = implode(' ', $itemClass);
                } else {
                    if (is_string($itemClass)) {
                        $liClass = [$itemClass];
                    } else {
                        $liClass = [];
                    }
                }
            } else {
                $liClass = [];
            }

            if (empty($crumb[1])) {
                $liClass[] = 'active';
            }
            if ( ! $which && $firstClass !== false) {
                $liClass[] = $firstClass;
            } elseif ($which == $crumbCount - 1 && $lastClass !== false) {
                $liClass[] = $lastClass;

            }
            if ( ! empty($liClass)) {
                $options['class'] = implode(' ', $liClass);
            }

            if ( ! empty($separator) && ($crumbCount - $which >= 2)) {
                $elementContent .= $separator;
            }
            $result .= $this->formatTemplate('breadCrumbLi', [
                'content' => $elementContent,
                'attrs' => $this->templater()->formatAttributes($options),
            ]);
        }

        return $this->formatTemplate('breadCrumbOl', [
            'content' => $result,
            'attrs' => $this->templater()->formatAttributes($ulOptions),
        ]);
    }

    /**
     * Creates a bootstrap button.
     *
     * If $url starts with "http://" this is treated as an external link. Else,
     * it is treated as a path to controller/action and parsed with the
     * UrlHelper::build() method.
     *
     * If the $url is empty, $title is used instead.
     *
     * ### Options
     *
     * - `size` Can be `small`, `normal` or `large` (default is `normal`)
     * - `class` Any additional css classes
     * - `secondary` Boolean true if you want secondary colour.
     * - `outline` Boolean true if you want button outlined.
     *
     * @param string            $title   The content to be used for the button.
     * @param string|array|null $url     Cake-relative URL or array of URL parameters, or
     *                                   external URL (starts with http://)
     * @param array             $options Array of options and HTML attributes.
     *
     * @return string the element.
     */
    public function button($title, $url = null, array $options = []) {
        $options = $options + [
                'size' => 'normal',
                'type' => 'link',
                'secondary' => false,
                'outline' => false,
                'class' => [],
            ];

        // Convert and sanitise the css class
        if (is_array($options['class'])) {
            $options['class'][] = 'btn';
        } else {
            if (is_string($options['class'])) {
                $options['class'] = ['btn', $options['class']];
            } else {
                $options['class'] = ['btn'];
            }
        }

        if ($options['outline'] === true) {
            $options['class'][] = $options['secondary'] === true ? 'btn-outline-secondary' : 'btn-outline-primary';
        } else {
            $options['class'][] = $options['secondary'] === true ? 'btn-secondary' : 'btn-primary';
        }

        switch ($options['size']) {
            case 'large':
            case 'lg':
                $options['class'][] = 'btn-lg';
                break;
            case 'small':
            case 'sm':
                $options['class'][] = 'btn-sm';
                break;
        }
        unset($options['size'], $options['secondary'], $options['outline']);

        if (in_array($options['type'], ['button', 'submit', 'reset'])) {
            return $this->tag('button', $title, $options);
        } else {
            unset($options['type']);
            $options += ['role' => 'button'];

            return $this->link($title, $url, $options);
        }
    }

    /**
     * Progress
     *
     * Returns a Bootstrap formatted progress
     *
     * @param int|array $values  Value(s) to represent. The follow arrays are accepted
     *                           [50,50], [[ 'value' => 50 ], [ 'value' => 50 ]] or
     *                           [[ 'value' => 50 ], [ 'value' => 50, 'label' => 'halfway there' ]]
     * @param array     $options Global array of options including `class`. Any of the `options` can be used in the
     *                           $values array
     *
     *   ### Options
     *
     * - `label`            Label to use for the progress, if true the percentage is used (default: false, no label)
     * - `striped`          Set to true for striped progress-bar (default: false)
     * - `animatedStripes` Set to true for animated stripes, setting to true also sets `striped` to true
     *                      (default: false)
     * - `escape`           Set to false to disable escaping of label
     * - `max`              The maximum value
     *
     * @return string the rendered html
     */
    public function progress($values, $options = []) {

        $options += [
            'label' => false,
            'striped' => false,
            'animatedStripes' => false,
            'max' => 100,
            'escape' => true,
        ];

        $progressBar = '';
        $accumulativeValue = 0;
        foreach ((array) $values as $item) {

            if ( ! is_array($item)) {
                $item = ['value' => $item];
            }

            $item += [
                'label' => $options['label'],
                'striped' => $options['striped'],
                'animatedStripes' => $options['animatedStripes'],
                'escape' => $options['escape'],
            ];

            $value = filter_var($item['value'], FILTER_SANITIZE_NUMBER_FLOAT,
                [
                    'flags' => FILTER_FLAG_ALLOW_FRACTION,
                ]
            );

            // No minus numbers
            $value = round($value < 0 ? 0 : $value);

            // Make sure the accumulativeVales don't exceed the max
            $accumulativeValue += $value;
            $value = ($accumulativeValue <= $options['max']) ? $value : $value + ($options['max'] - $accumulativeValue);

            if ($value > 0) {
                $valueAsPercentage = 100 / ($options['max'] / $value);
            } else {
                $valueAsPercentage = 0;
            }

            $progressBarOptions = $item + [
                    'role' => 'progressbar',
                    'style' => sprintf('width:%.2f%%', $valueAsPercentage),
                    'aria-valuenow' => $value,
                    'aria-valuemin' => 0,
                    'aria-valuemax' => $options['max'],
                ];

            if ($item['animatedStripes']) {
                $item['striped'] = true;
            }

            $progressBarOptions = $this->customAddClass($progressBarOptions, ['progress-bar']);
            if ($item['striped']) {
                if ($item['animatedStripes']) {
                    $progressBarOptions = $this->customAddClass($progressBarOptions, ['progress-bar-striped', 'progress-bar-animated']);
                } else {
                    $progressBarOptions = $this->customAddClass($progressBarOptions, ['progress-bar-striped']);
                }
            }

            $labelStr = '';
            if ($item['label'] !== false) {
                if ($item['label'] === true) {
                    $labelStr = h(sprintf('%.1f%%', $valueAsPercentage));
                } else {
                    $labelStr = $item['escape'] ? h($item['label']) : $item['label'];
                }
            }

            // Filter out the options
            $progressBarOptions = $this->array_filter_keys($progressBarOptions,
                ['label', 'max', 'striped', 'escape', 'animatedStripes', 'value']);

            $progressBar .= $this->tag('div', $labelStr, $progressBarOptions);
        }

        $options = $this->customAddClass($options, 'progress');

        // Filter out the options
        $options = $this->array_filter_keys($options, ['label', 'max', 'striped', 'escape', 'animatedStripes']);

        return $this->tag('div', $progressBar, $options);
    }

    private function array_filter_keys($array, $keys) {
        return array_filter($array, function($key) use ($keys) {
            return ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Adds a class and returns a unique list either in array or space separated
     *
     * ### Options
     *
     * - `useIndex` if you are inputting an array with an 'element' other than 'class'.
     *              Also setting to 'false' will manipulate the whole array (default is 'class')
     * - `asString` Setting this to `true` will return a space separated string (default is `false`)
     *
     * @param array|string $input    The array or string to add the class to
     * @param array|string $newClass the new class or classes to add
     * @param array        $options  See above for options
     *
     * @return array|string
     */
    public function customAddClass($input, $newClass, $options = []) {
        // NOOP
        if (empty($newClass)) {
            return $input;
        }

        $options += [
            'useIndex' => 'class',
            'asString' => false,
        ];

        $useIndex = $options['useIndex'];
        if (is_string($useIndex) && is_array($input)) {
            $class = Hash::get($input, $useIndex, []);
        } else {
            $class = $input;
        }

        // Convert and sanitise the inputs
        if ( ! is_array($class)) {
            if (is_string($class) && ! empty($class)) {
                $class = explode(' ', $class);
            } else {
                $class = [];
            }
        }

        if (is_string($newClass)) {
            $newClass = explode(' ', $newClass);
        }

        $class = array_unique(array_merge($class, $newClass));

        if ($options['asString'] === true) {
            $class = implode(' ', $class);
        }

        if (is_string($useIndex)) {
            if ( ! is_array($input)) {
                $input = [];
            }
            $input = Hash::insert($input, $useIndex, $class);
        } else {
            $input = $class;
        }

        return $input;
    }

}
