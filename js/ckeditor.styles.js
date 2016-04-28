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

  { name: 'White link', element: 'a', styles: { 'color': 'white' } },
  { name: 'Bright blue link', element: 'a', styles: { 'color': 'rgb(2, 66, 111);' } },
  { name: 'Dark blue link', element: 'a', styles: { 'color': 'rgb(30, 157, 216);' } },
  { name: 'White text', element: 'a', styles: { 'color': '#ffffff' } },
  { name: 'Bright blue text', element: 'a', styles: { 'color': 'rgb(2, 66, 111);' } },
  { name: 'Dark blue text', element: 'a', styles: { 'color': 'rgb(30, 157, 216);' } },

  /* Object Styles */

  { name: 'Float image left',
    element: 'img',
    attributes: { 'float': 'left', 'margin-right' : '10px', 'margin-bottom' : '10px' }
  },
  { name: 'Float image right',
    element: 'img',
    attributes: { 'float': 'right', 'margin-left' : '10px', 'margin-bottom' : '10px' }
  },
  { name: 'Portrait image (email)',
    element: 'img',
    attributes: { 'width': '100%', 'height' : 'auto' }
  },
  { name: 'Landscape image (email)',
    element: 'img',
    attributes: { 'width': '280px', 'height' : 'auto' }
  }
] );

