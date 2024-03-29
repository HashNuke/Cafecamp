/*
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
 * @fileoverview Representation of an url.
 */


/**
 * @class
 * Base interface for all url objects.
 *
 * @name opensocial.Url
 */


/**
 * Base interface for all url objects.
 *
 * @private
 * @constructor
 */
opensocial.Url = function() {};


/**
 * @static
 * @class
 * All of the fields that a url has. These are the supported keys for the
 * <a href="opensocial.Url.html#getField">Url.getField()</a> method.
 *
 * @name opensocial.Url.Field
 */
opensocial.Url.Field = {
  /**
   * The url number type or label. Examples: work, blog feed,
   * website, etc Specified as a String.
   */
  TYPE : 'type',

  /**
   * The text of the link. Specified as a String.
   */
  LINK_TEXT : 'linkText',

  /**
   * The address the url points to. Specified as a String.
   */
  ADDRESS : 'address'
};


/**
 * Gets data for this url that is associated with the specified key.
 *
 * @param {String} key The key to get data for;
 *    keys are defined in <a href="opensocial.Url.Field.html"><code>
 *    Url.Field</code></a>
 * @return {String} The data
 */
opensocial.Url.prototype.getField = function(key) {};