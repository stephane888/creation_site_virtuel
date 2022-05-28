<?php

namespace Drupal\creation_site_virtuel\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsWidgetBase;
use Stephane888\Debug\debugLog;

/**
 * Plugin implementation of the 'options_buttons' widget.
 *
 * @FieldWidget(
 *   id = "selectfilter_theme",
 *   label = @Translation(" selection de theme "),
 *   field_types = {
 *     "entity_reference",
 *     "list_integer",
 *     "list_float",
 *     "list_string",
 *     "boolean",
 *   },
 *   multiple_values = TRUE
 * )
 */
class SelectfilterTheme extends OptionsWidgetBase {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\Core\Field\PluginSettingsBase::defaultSettings()
   */
  public static function defaultSettings() {
    
    // TODO Auto-generated method stub
    $settings = [
      'test' => 'humm',
      'mappings' => [
        [
          'label' => ''
        ]
      ],
      'list_options' => [
        self::addOption()
      ]
    ];
    $settings += parent::defaultSettings();
    return $settings;
  }
  
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();
    $element = parent::settingsForm($form, $form_state);
    // $element['test'] = [
    // '#type' => 'textfield',
    // '#title' => 'titre',
    // '#default_value' => $settings['test']
    // ];
    // $element['mappings'] = [
    // '#type' => 'html_tag',
    // '#tag' => 'section',
    // "#attributes" => [
    // 'id' => 'list-field-options',
    // 'class' => []
    // ],
    // '#weight' => 0
    // ];
    
    // $element['mappings'][0] = [
    // '#type' => 'details',
    // '#open' => false,
    // '#title' => 'Option test : 0'
    // ];
    // $element['mappings'][0]['label'] = [
    // '#type' => 'textfield',
    // '#title' => 'titre',
    // '#default_value' => $settings['mappings'][0]['label']
    // ];
    $this->custombuildList($element, $settings, $form_state);
    //
    $element['donnee-internet-entity'] = [
      '#type' => 'html_tag',
      '#tag' => 'section',
      "#attributes" => [
        'id' => 'donnee-internet-entity-next-field',
        'class' => [
          'step-donneesite',
          'mx-auto',
          'text-center'
        ]
      ],
      '#weight' => 10
    ];
    //
    $element['donnee-internet-entity']['add-more'] = [
      '#type' => 'submit',
      '#value' => 'add option',
      '#button_type' => 'secondary',
      '#submit' => [
        [
          $this,
          'AddOptionFieldSubmit'
        ]
      ],
      '#ajax' => [
        'callback' => [
          $this,
          'AddOptionFieldSCallback'
        ],
        'wrapper' => 'list-field-options',
        'effect' => 'fade',
        'event' => 'click'
      ],
      '#attributes' => [
        'class' => [
          'd-inline-block',
          'w-auto'
        ],
        'data-trigger' => 'run'
      ]
    ];
    //
    $element['donnee-internet-entity']['save-image'] = [
      '#type' => 'submit',
      '#value' => 'Save image',
      '#button_type' => 'secondary',
      '#submit' => [
        [
          $this,
          'selectNextFieldSubmit'
        ]
      ],
      '#ajax' => [
        'callback' => [
          $this,
          'selectNextFieldSCallback'
        ],
        'wrapper' => 'donnee-internet-entity-next-field',
        'effect' => 'fade',
        'event' => 'click'
      ],
      '#attributes' => [
        'class' => [
          'd-inline-block',
          'w-auto'
        ],
        'data-trigger' => 'run'
      ]
    ];
    return $element;
  }
  
  public function custombuildList(&$element, $settings, FormStateInterface $form_state) {
    $nbre_preview = 0;
    $nbre = count($settings['list_options']);
    if ($form_state->has([
      $this->fieldDefinition->getName(),
      'list_options'
    ])) {
      $nbre_preview = count($form_state->get([
        $this->fieldDefinition->getName(),
        'list_options'
      ]));
      if ($nbre_preview > $nbre) {
        $nbre = $nbre_preview;
      }
    }
    else {
      $list = $settings['list_options'];
      $form_state->set([
        $this->fieldDefinition->getName(),
        'list_options'
      ], $list);
    }
    
    // $this->messenger()->addStatus(" List_options : " . $nbre_preview . ' :: '
    // . $this->fieldDefinition->getName() . ' :: ' . $nbre . ' :: ' .
    // json_encode($settings['list_options']), true);
    $element['list_options'] = [
      '#type' => 'html_tag',
      '#tag' => 'section',
      "#attributes" => [
        'id' => 'list-field-options',
        'class' => []
      ],
      '#weight' => 0
    ];
    for ($k = 0; $k < $nbre; $k++) {
      if (!empty($settings['list_options'][$k])) {
        $option = $settings['list_options'][$k];
      }
      else {
        $option = self::addOption();
      }
      //
      $element['list_options'][$k] = [
        '#type' => 'details',
        '#open' => false,
        '#title' => 'Option : ' . $k
      ];
      $element['list_options'][$k]['label'] = [
        '#type' => 'textfield',
        '#title' => 'Label option',
        '#default_value' => $option['label']
      ];
      
      $element['list_options'][$k]['value'] = [
        '#type' => 'textfield',
        '#title' => ' Value option ',
        '#default_value' => $option['value']
      ];
      $element['list_options'][$k]['description'] = [
        '#type' => 'text_format',
        '#title' => ' Description ',
        '#format' => (isset($option['description']["format"])) ? $option['description']["format"] : 'full_html',
        '#default_value' => (isset($option['description']["value"])) ? $option['description']["value"] : '',
        '#rows' => 2
      ];
      $element['list_options'][$k]['image'] = [
        '#type' => 'managed_file',
        '#title' => 'image',
        '#default_value' => $option['image'],
        '#upload_location' => 'public://fields/' . $this->fieldDefinition->getName()
      ];
    }
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function settingsForm0(array $formParent, FormStateInterface $form_state) {
    $form = [];
    $settings = $this->getSettings();
    
    // Affichage des options.
    $form['donnee-internet-entity'] = [
      '#type' => 'html_tag',
      '#tag' => 'section',
      "#attributes" => [
        'id' => 'donnee-internet-entity-next-field',
        'class' => [
          'step-donneesite',
          'mx-auto',
          'text-center'
        ]
      ],
      '#weight' => 10
    ];
    
    $form['list_options'] = [
      '#type' => 'html_tag',
      '#tag' => 'section',
      "#attributes" => [
        'id' => 'list-field-options',
        'class' => []
      ],
      '#weight' => 0
    ];
    
    //
    $list = [];
    if (!empty($settings['list_options']) || $form_state->has([
      $this->fieldDefinition->getName(),
      'list_options'
    ])) {
      if ($form_state->has([
        $this->fieldDefinition->getName(),
        'list_options'
      ])) {
        $list = $form_state->get([
          $this->fieldDefinition->getName(),
          'list_options'
        ]);
      }
      else {
        $list = $settings['list_options'];
        $form_state->set([
          $this->fieldDefinition->getName(),
          'list_options'
        ], $list);
      }
      //
      
      foreach ($list as $k => $option) {
        $form['list_options'][$k] = [
          '#type' => 'details',
          '#open' => false,
          '#title' => 'Option : ' . $k
        ];
        $form['list_options'][$k]['label'] = [
          '#type' => 'textfield',
          '#title' => 'Label option',
          '#default_value' => $option['label']
        ];
        
        $form['list_options'][$k]['value'] = [
          '#type' => 'textfield',
          '#title' => ' Value option ',
          '#default_value' => $option['value']
        ];
        $form['list_options'][$k]['description'] = [
          '#type' => 'text_format',
          '#title' => ' Description ',
          '#format' => (isset($option['description']["format"])) ? $option['description']["format"] : 'full_html',
          '#default_value' => (isset($option['description']["value"])) ? $option['description']["value"] : '',
          '#rows' => 2
        ];
        $form['list_options'][$k]['image'] = [
          '#type' => 'managed_file',
          '#title' => 'image',
          '#default_value' => $option['image'],
          '#upload_location' => 'public://fields/' . $this->fieldDefinition->getName(),
          '#submit' => [
            [
              $this,
              'save_image_callback'
            ]
          ]
        ];
      }
    }
    // $submit = function ($form, \Drupal\Core\Form\FormStateInterface
    // $form_state) {
    // $values = $form_state->getValue('list_options', []);
    // if (!empty($values)) {
    // $this->messenger()->addStatus("call_back", true);
    // // $fid = $values[0];
    // // $file = \Drupal\file\Entity\File::load($fid);
    // // $file_usage = \Drupal::service('file.usage');
    // // $file_usage->add($file, 'casper', 'theme', 1);
    // foreach ($values as $value) {
    // //
    // }
    // }
    // };
    
    $form['donnee-internet-entity']['add-more'] = [
      '#type' => 'submit',
      '#value' => 'add option',
      '#button_type' => 'secondary',
      '#submit' => [
        [
          $this,
          'AddOptionFieldSubmit'
        ]
      ],
      '#ajax' => [
        'callback' => [
          $this,
          'AddOptionFieldSCallback'
        ],
        'wrapper' => 'list-field-options',
        'effect' => 'fade',
        'event' => 'click'
      ],
      '#attributes' => [
        'class' => [
          'd-inline-block',
          'w-auto'
        ],
        'data-trigger' => 'run'
      ]
    ];
    //
    $form['donnee-internet-entity']['save-image'] = [
      '#type' => 'submit',
      '#value' => 'Save image',
      '#button_type' => 'secondary',
      '#submit' => [
        [
          $this,
          'selectNextFieldSubmit'
        ]
      ],
      '#ajax' => [
        'callback' => [
          $this,
          'selectNextFieldSCallback'
        ],
        'wrapper' => 'donnee-internet-entity-next-field',
        'effect' => 'fade',
        'event' => 'click'
      ],
      '#attributes' => [
        'class' => [
          'd-inline-block',
          'w-auto'
        ],
        'data-trigger' => 'run'
      ]
    ];
    //
    return $form;
  }
  
  //
  public function selectNextFieldSubmit($form, FormStateInterface $form_state) {
    $trigger = $form_state->getTriggeringElement();
    $element = [];
    foreach ($trigger['#array_parents'] as $fielname) {
      if ($fielname != 'plugin')
        $element[] = $fielname;
      if ($fielname == 'settings') {
        break;
      }
    }
    $element[] = 'list_options';
    $list = $form_state->getValue($element);
    foreach ($list as $option) {
      if (!empty($option['image'])) {
        $fid = reset($option['image']);
        $file = \Drupal\file\Entity\File::load($fid);
        if ($file && $file->isTemporary()) {
          $this->messenger()->addStatus(' Image save success ');
          $file->setPermanent();
          $file->save();
        }
      }
    }
  }
  
  //
  public function selectNextFieldSCallback(array $form, FormStateInterface $form_state) {
    // debugLog::$max_depth = 7;
    // debugLog::kintDebugDrupal($form_state->getTriggeringElement(),
    // 'selectNextFieldSCallback', true);
    $trigger = $form_state->getTriggeringElement();
    $element = null;
    foreach ($trigger['#array_parents'] as $fielname) {
      if (!$element) {
        $element = $form[$fielname];
      }
      else {
        $element = $element[$fielname];
      }
      if ($fielname == 'settings') {
        break;
      }
    }
    return $element['donnee-internet-entity'];
  }
  
  /**
   *
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function AddOptionFieldSubmit(array $form, FormStateInterface $form_state) {
    if ($form_state->has([
      $this->fieldDefinition->getName(),
      'list_options'
    ])) {
      $list = $form_state->get([
        $this->fieldDefinition->getName(),
        'list_options'
      ]);
      if ($this->fieldDefinition->getType() == 'boolean') {
        if (count($list) < 2) {
          $list[] = self::addOption();
          $form_state->set([
            $this->fieldDefinition->getName(),
            'list_options'
          ], $list);
        }
        else {
          $this->messenger()->addWarning(' Vous avez atteint la limite ');
        }
      }
      else {
        $list[] = self::addOption();
        $form_state->set([
          $this->fieldDefinition->getName(),
          'list_options'
        ], $list);
      }
    }
    else {
      $list = [
        self::addOption()
      ];
      $form_state->set([
        $this->fieldDefinition->getName(),
        'list_options'
      ], $list);
    }
    $form_state->setRebuild(true);
  }
  
  /**
   *
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function AddOptionFieldSCallback(array $form, FormStateInterface $form_state) {
    $trigger = $form_state->getTriggeringElement();
    $element = null;
    foreach ($trigger['#array_parents'] as $fielname) {
      if (!$element) {
        $element = $form[$fielname];
      }
      else {
        $element = $element[$fielname];
      }
      if ($fielname == 'settings') {
        break;
      }
    }
    return $element['list_options'];
  }
  
  function save_image_callback(FormStateInterface $form_state, $form) {
    // debugLog::kintDebugDrupal($element, 'element_validate', true);
    // if (!empty($element['#default_value 2'])) {
    // //
    // }
    $this->messenger()->addStatus("save_image_callback 2", true);
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $this->messenger()->addStatus(' selectfilter_theme : ' . $items->getName(), true);
    // if ('field_liste_option' == $items->getName()) {
    // dump($items->getFieldDefinition());
    // }
    
    $options = $this->getOptions($items->getEntity());
    $selected = $this->getSelectedOptions($items);
    
    // If required and there is one single option, preselect it.
    if ($this->required && count($options) == 1) {
      reset($options);
      $selected = [
        key($options)
      ];
    }
    
    if ($this->multiple) {
      $element += [
        '#type' => 'checkboxes',
        '#default_value' => $selected,
        '#options' => $options
      ];
    }
    else {
      $element += [
        '#type' => 'radios',
        // Radio buttons need a scalar value. Take the first default value, or
        // default to NULL so that the form element is properly recognized as
        // not having a default value.
        '#default_value' => $selected ? reset($selected) : NULL,
        '#options' => $options
      ];
    }
    
    return $element;
  }
  
  public static function addOption() {
    return [
      'label' => '',
      'value' => '',
      'description' => [],
      'image' => []
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    // dump($values);
    // die();
    return $values;
  }
  
}