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
 * @fileoverview
 *
 * Provides access to user prefs, module dimensions, and messages.
 *
 * Clients can access their preferences by constructing an instance of
 * gadgets.Prefs and passing in their module id.  Example:
 *
 *   var prefs = new gadgets.Prefs();
 *   var name = prefs.getString("name");
 *   var lang = prefs.getLang();
 *
 * Modules with type=url can also use this library to parse arguments passed
 * by URL, but this is not the common case:
 *
 *   &lt;script src="http://apache.org/shindig/prefs.js"&gt;&lt;/script&gt;
 *   &lt;script&gt;
 *   gadgets.Prefs.parseUrl();
 *   var prefs = new gadgets.Prefs();
 *   var name = prefs.getString("name");
 *   &lt;/script&lg;
 */

var gadgets = gadgets || {};

/**
 * @class A class gadgets can use to get user preference information.
 *
 * @description Creates a new Prefs object
 * @param {String | Number} opt_moduleId An optional parameters specifying the
 *     module id to create prefs for. If not provided, the default module id
 *     will be used.
 */
gadgets.Prefs = function(opt_moduleId) {};

/**
 * Retrieves a string preference.
 * @param {String} key The preference to fetch.
 * @return {String} The preference. If not set, an empty string.
 */
gadgets.Prefs.prototype.getString = function(key) {};

/**
 * Retrieves an integer preference.
 * @param {String} key The preference to fetch.
 * @return {Number} The preference. If not set, 0.
 */
gadgets.Prefs.prototype.getInt = function(key) {};

/**
 * Retrieves a floating point preference.
 * @param {String} key The preference to fetch.
 * @return {Number} The preference. If not set, 0.
 */
gadgets.Prefs.prototype.getFloat = function(key) {};

/**
 * Retrieves a boolean preference.
 * @param {String} key The preference to fetch.
 * @return {Boolean} The preference. If not set, false.
 */
gadgets.Prefs.prototype.getBool = function(key) {};

/**
 * Stores a preference.
 * Note: If the gadget needs to store an Array it should use setArray instead of
 * this call.
 * Note: The gadget must require the feature setprefs in
 * order to use this call.
 *
 * @param {String} key The pref to store.
 * @param {Object} val The values to store.
 */
gadgets.Prefs.prototype.set = function(key, value) {};

/**
 * Retrieves an array preference.
 * @param {String} key The preference to fetch.
 * @return {Array.<String>} The preference. If not set, an empty array.
 *     UserPref values that were not declared as lists will be treated as
 *     1 element arrays.
 */
gadgets.Prefs.prototype.getArray = function(key) {};

/**
 * Stores an array preference. The gadget must require the feature setprefs in
 * order to use this call.
 *
 * @param {String} key The pref to store.
 * @param {Array} val The values to store.
 */
gadgets.Prefs.prototype.setArray = function(key, val) {};

/**
 * Fetches an unformatted message.
 * @param {String} key The message to fetch
 * @return {String} The message.
 */
gadgets.Prefs.prototype.getMsg = function(key) {};

/**
 * Returns a message value with the positional argument opt_subst in place if
 * it is provided or the provided example value if it is not, or the empty
 * string if the message is not found.
 * Eventually we may provide controls to return different default messages.
 *
 * @param {String} key The message to fetch.
 * @param {String} opt_subst An optional string to substitute into the message.
 * @return {String} The formatted string.
 */
gadgets.Prefs.prototype.getMsgFormatted = function(key, opt_subst) {};

/**
 * Gets the current country, returned as ISO 3166-1 alpha-2 code.
 *
 * @return {String} The country for this module instance.
 */
gadgets.Prefs.prototype.getCountry = function() {};

/**
 * Gets the current language the gadget should use when rendering, returned as a
 * ISO 639-1 language code.
 *
 * @return {String} The language for this module instance.
 */
gadgets.Prefs.prototype.getLang = function() {};

/**
 * Gets the module id for the current instance.
 *
 * @return {String | Number} The module id for this module instance.
 */
gadgets.Prefs.prototype.getModuleId = function() {};
