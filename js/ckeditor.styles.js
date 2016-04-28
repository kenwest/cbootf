// This file contains style definitions that can be used by CKEditor plugins.
//
// There is a styleset for CiviCRM and Drupal. The CiviCRM one is a subset of
// those styles that can be used in emails.

CKEDITOR.stylesSet.add( 'civicrm', [
  /*
   * The 'civicrm' styleset only includes those styles that can be used in CiviMails.
   * So, no styles include class attributes.
   */

  /* Block Styles */

  /* Inline Styles */

  { name: 'White text',       element: 'span', styles: { 'color': 'white' } },
  { name: 'Bright blue text', element: 'span', styles: { 'color': 'rgb(30, 157, 216)' } },
  { name: 'Dark blue text',   element: 'span', styles: { 'color': 'rgb(2, 66, 111)' } },
  { name: 'Normal text',      element: 'span', styles: { 'color': '' } },

  /* Object Styles */

  { name: 'White link',       element: 'a', styles: { 'color': 'white' } },
  { name: 'Bright blue link', element: 'a', styles: { 'color': 'rgb(30, 157, 216)' } },
  { name: 'Dark blue link',   element: 'a', styles: { 'color': 'rgb(2, 66, 111)' } },
  { name: 'Normal link',      element: 'a', styles: { 'color': '' } },

  { name: 'Float image left',
    element: 'img',
    styles: { 'float': 'left', 'margin-right' : '10px', 'margin-bottom' : '10px' }
  },
  { name: 'Float image right',
    element: 'img',
    styles: { 'float': 'right', 'margin-left' : '10px', 'margin-bottom' : '10px' }
  },
  { name: 'Email portrait',
    element: 'img',
    attributes: { 'width': '280',  'height' : '' },
    styles:     { 'width': '100%', 'height' : '', 'max-width' : '280px' }
  },
  { name: 'Email landscape',
    element: 'img',
    attributes: { 'width': '280',   'height' : '' },
    styles:     { 'width': '280px', 'height' : '' }
  }
] );

