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
 * @fileoverview Representation of an email.
 */


/**
 * @class
 * Base interface for all email objects.
 *
 * @name opensocial.Email
 */


/**
 * Base interface for all email objects.
 *
 * @private
 * @constructor
 */
opensocial.Email = function() {};


/**
 * @static
 * @class
 * All of the fields that an email has. These are the supported keys for the
 * <a href="opensocial.Email.html#getField">Email.getField()</a> method.
 *
 * @name opensocial.Email.Field
 */
opensocial.Email.Field = {
  /**
   * The email type or label. Examples: work, my favorite store,
   * my house, etc Specified as a String.
   */
  TYPE : 'type',

  /**
   * The email address. Specified as a String.
   */
  ADDRESS : 'address'
};


/**
 * Gets data for this body type that is associated with the specified key.
 *
 * @param {String} key The key to get data for;
 *    keys are defined in <a href="opensocial.Email.Field.html"><code>
 *    Email.Field</code></a>
 * @return {String} The data
 */
opensocial.Email.prototype.getField = function(key) {};