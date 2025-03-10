<?php

namespace EssentialElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "EssentialElements\\AccordionContent",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class AccordionContent extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'SquareIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return [];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Accordion Content';
    }

    static function className()
    {
        return 'bde-accordion__content-wrapper';
    }

    static function category()
    {
        return 'other';
    }

    static function badge()
    {
        return false;
    }

    static function slug()
    {
        return get_class();
    }

    static function template()
    {
        return file_get_contents(__DIR__ . '/html.twig');
    }

    static function defaultCss()
    {
        return file_get_contents(__DIR__ . '/default.css');
    }

    static function defaultProperties()
    {
        return false;
    }

    static function defaultChildren()
    {
        return false;
    }

    static function cssTemplate()
    {
        $template = file_get_contents(__DIR__ . '/css.twig');
        return $template;
    }

    static function designControls()
    {
        return [c(
        "container",
        "Container",
        [c(
        "background",
        "Background",
        [],
        ['type' => 'color', 'layout' => 'inline', 'colorOptions' => ['type' => 'solidAndGradient']],
        false,
        false,
        [],
      ), getPresetSection(
      "EssentialElements\\spacing_padding_all",
      "Padding",
      "padding",
       ['type' => 'popout']
     )],
        ['type' => 'section'],
        false,
        false,
        [],
      ), getPresetSection(
      "EssentialElements\\simpleLayout",
      "Layout",
      "layout",
       ['type' => 'popout']
     ), c(
        "text_colors",
        "Text Colors",
        [c(
        "headings",
        "Headings",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "text",
        "Text",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
      ), c(
        "link",
        "Link",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        true,
        [],
      ), c(
        "brand",
        "Brand",
        [],
        ['type' => 'color', 'layout' => 'inline'],
        false,
        false,
        [],
      )],
        ['type' => 'section', 'condition' => ['0' => ['0' => ['path' => 'design.text_colors', 'operand' => 'is set', 'value' => '']]]],
        false,
        false,
        [],
      )];
    }

    static function contentControls()
    {
        return [c(
        "content",
        "Content",
        [c(
        "title",
        "Title",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'textOptions' => ['multiline' => true]],
        false,
        false,
        [],
      ), c(
        "title_tag",
        "Title Tag",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => ['0' => ['value' => 'h1', 'text' => 'h1'], '1' => ['text' => 'h2', 'value' => 'h2'], '2' => ['text' => 'h3', 'value' => 'h3'], '3' => ['text' => 'h4', 'value' => 'h4'], '4' => ['text' => 'h5', 'value' => 'h5'], '5' => ['text' => 'h6', 'value' => 'h6']], 'placeholder' => 'h3'],
        false,
        false,
        [],
      )],
        ['type' => 'section'],
        false,
        false,
        [],
      )];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return false;
    }

    static function settings()
    {
        return ['shareStateWithChildSSR' => true, 'bypassPointerEvents' => false];
    }

    static function addPanelRules()
    {
        return ['alwaysHide' => false];
    }

    static public function actions()
    {
        return [

'onCreatedElement' => [['script' => ' window.manageBreakdanceAdvancedAccordion && window.manageBreakdanceAdvancedAccordion().update(\'%%SELECTOR%%\')',
],],

'onActivatedElement' => [['script' => 'window.manageBreakdanceAdvancedAccordion && window.manageBreakdanceAdvancedAccordion().activateTabFromStructurePanel(\'%%SELECTOR%%\')','runForAllChildren' => true,
],],

'onMovedElement' => [['script' => ' window.manageBreakdanceAdvancedAccordion && window.manageBreakdanceAdvancedAccordion().update(\'%%SELECTOR%%\')','runForAllChildren' => true,
],],

'onBeforeDeletingElement' => [['script' => ' window.manageBreakdanceAdvancedAccordion && window.manageBreakdanceAdvancedAccordion().update(\'%%SELECTOR%%\')',
],],];
    }

    static function nestingRule()
    {
        return ["type" => "container", "restrictedToBeADirectChildOf" => ['EssentialElements\AdvancedAccordion'],  ];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return false;
    }

    static function experimental()
    {
        return false;
    }

    static function order()
    {
        return 0;
    }

    static function dynamicPropertyPaths()
    {
        return false;
    }

    static function additionalClasses()
    {
        return false;
    }

    static function projectManagement()
    {
        return false;
    }

    static function propertyPathsToWhitelistInFlatProps()
    {
        return false;
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
