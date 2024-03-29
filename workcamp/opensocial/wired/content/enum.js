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
 * @fileoverview Representation of an enum.
 */


/**
 * @class
 * Base interface for all enum objects.
 * This class allows containers to use constants for fields that are usually
 * have a common set of values.
 *
 * There are two main ways to use this class.
 * If your gadget just wants to display how much of a smoker someone is,
 * it can simply use:
 *
 * html = "This person smokes: " + person.getField('smoker').getValue();
 *
 * This value field will be correctly setup by the container. This is a place
 * where the container can even localize the value for the gadget so that it
 * always shows the right thing.
 *
 * If on the other hand your gadget wants to have some logic around the smoker
 * field it can use:
 *
 * if (person.getField('smoker').getKey() != "NO") { //gadget logic here }
 *
 * Note: The key may be null if the person's smoker field can not be coereced
 * into one of the standard enum types. The value on the otherhand will never be
 * null.
 *
 * @name opensocial.Enum
 */


/**
 * Base interface for all enum objects.
 *
 * @private
 * @constructor
 */
opensocial.Enum = function() {};


/**
 * Use this for logic within your gadget. If they key is null then the value
 * does not fit in the defined enums.
 *
 * @return {String} The enum's key. This should be one of the defined enums
 *     below.
 */
opensocial.Enum.prototype.getKey = function() {};


/**
 * The value of this enum. This will be a user displayable string. If the
 * container supports localization, the string will be localized.
 *
 * @return {String} The enum's value.
 */
opensocial.Enum.prototype.getDisplayValue = function() {};


/**
 * @static
 * @class
 * The enum keys used by the smoker field.
 * <p><b>See also:</b>
 * <a href="opensocial.Person.Field.html">
 * opensocial.Person.Field.Smoker</a>
 * </p>
 *
 * @name opensocial.Enum.Smoker
 */
opensocial.Enum.Smoker = {
  /** @member opensocial.Enum.Smoker */
  NO : 'NO',
  /** @member opensocial.Enum.Smoker */
  YES : 'YES',
  /** @member opensocial.Enum.Smoker */
  SOCIALLY : 'SOCIALLY',
  /** @member opensocial.Enum.Smoker */
  OCCASIONALLY : 'OCCASIONALLY',
  /** @member opensocial.Enum.Smoker */
  REGULARLY : 'REGULARLY',
  /** @member opensocial.Enum.Smoker */
  HEAVILY : 'HEAVILY',
  /** @member opensocial.Enum.Smoker */
  QUITTING : 'QUITTING',
  /** @member opensocial.Enum.Smoker */
  QUIT : 'QUIT'
};


/**
 * @static
 * @class
 * The enum keys used by the drinker field.
 * <p><b>See also:</b>
 * <a href="opensocial.Person.Field.html">
 * opensocial.Person.Field.Drinker</a>
 * </p>
 *
 * @name opensocial.Enum.Drinker
 */
opensocial.Enum.Drinker = {
  /** @member opensocial.Enum.Drinker */
  NO : 'NO',
  /** @member opensocial.Enum.Drinker */
  YES : 'YES',
  /** @member opensocial.Enum.Drinker */
  SOCIALLY : 'SOCIALLY',
  /** @member opensocial.Enum.Drinker */
  OCCASIONALLY : 'OCCASIONALLY',
  /** @member opensocial.Enum.Drinker */
  REGULARLY : 'REGULARLY',
  /** @member opensocial.Enum.Drinker */
  HEAVILY : 'HEAVILY',
  /** @member opensocial.Enum.Drinker */
  QUITTING : 'QUITTING',
  /** @member opensocial.Enum.Drinker */
  QUIT : 'QUIT'
};


/**
 * @static
 * @class
 * The enum keys used by the gender field.
 * <p><b>See also:</b>
 * <a href="opensocial.Person.Field.html">
 * opensocial.Person.Field.Gender</a>
 * </p>
 *
 * @name opensocial.Enum.Gender
 */
opensocial.Enum.Gender = {
  /** @member opensocial.Enum.Gender */
  MALE : 'MALE',
  /** @member opensocial.Enum.Gender */
  FEMALE : 'FEMALE'
};