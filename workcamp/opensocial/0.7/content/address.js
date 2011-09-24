/*
 * Copyright 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @fileoverview Representation of an address.
 */


/**
 * @class
 * Base interface for all address objects.
 *
 * @name opensocial.Address
 */


/**
 * Base interface for all address objects.
 *
 * @private
 * @constructor
 */
opensocial.Address = function() {};


/**
 * @static
 * @class
 * All of the fields that an address has. These are the supported keys for the
 * <a href="opensocial.Address.html#getField">Address.getField()</a> method.
 *
 * @name opensocial.Address.Field
 */
opensocial.Address.Field = {
  /**
   * The address type or label. Examples: work, my favorite store, my house, etc
   * Specified as a String.
   */
  TYPE : 'type',

  /**
   * If the container does not have structured addresses in its data store,
   * this field will return the unstructured address that the user entered. Use
   * opensocial.getEnvironment().supportsField to see which fields are
   * supported. Specified as a String.
   */
  UNSTRUCTURED_ADDRESS : 'unstructuredAddress',

  /**
   * The po box of the address if there is one. Specified as a String.
   */
  PO_BOX : 'poBox',

  /**
   * The street address. Specified as a String.
   */
  STREET_ADDRESS : 'streetAddress',

  /**
   * The extended street address. Specified as a String.
   */
  EXTENDED_ADDRESS : 'extendedAddress',

  /**
   * The region. Specified as a String.
   */
  REGION : 'region',

  /**
   * The locality. Specified as a String.
   */
  LOCALITY : 'locality',

  /**
   * The postal code. Specified as a String.
   */
  POSTAL_CODE : 'postalCode',

  /**
   * The country. Specified as a String.
   */
  COUNTRY : 'country',

  /**
   * The latitude. Specified as a Number.
   */
  LATITUDE : 'latitude',

  /**
   * The longitude. Specified as a Number.
   */
  LONGITUDE : 'longitude'
};


/**
 * Gets data for this body type that is associated with the specified key.
 *
 * @param {String} key The key to get data for;
 *    keys are defined in <a href="opensocial.Address.Field.html"><code>
 *    Address.Field</code></a>
 * @return {String} The data
 */
opensocial.Address.prototype.getField = function(key) {};